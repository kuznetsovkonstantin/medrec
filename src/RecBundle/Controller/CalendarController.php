<?php
namespace RecBundle\Controller;

use Doctrine\ORM\EntityManager;
use RecBundle\Entity\ClndrSettings;
use RecBundle\Entity\Record;
use RecBundle\Entity\Serv;
use RecBundle\Entity\Spec;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RecBundle\Form\ClndrSettingsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class CalendarController extends Controller
{
    public function showAction(Request $request) {

        $settings = $this->getDoctrine()->getRepository(ClndrSettings::class)->find(1);
        $settForm = $this->createForm(ClndrSettingsType::class,$settings);

        $settForm->handleRequest($request);

        if($settForm->isSubmitted() && $settForm->isValid()) {

            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            $em = $this->getDoctrine()->getManager();
            $em->persist($settings);
            $em->flush();

            $this->addFlash("success", "Данные успешно сохранены");

            return $this->redirectToRoute('pdays');
        }

        return $this->render('@RecBundle/Calendar/show.html.twig',array(
            'settForm'=>$settForm->createView()
        ));
    }

    public function getClndrAction($spec = null,$serv = null,$loc = 'day') {
        $clMan = $this->get('clndr.manager');

        $countSpec = is_null($spec)? $this->getDoctrine()->getRepository(Spec::class)->getCountSpec() : 1;

        $arrDates = $clMan->getDates();
        $arrDis = $clMan->getArrDis($arrDates[0],$arrDates[($clMan->countDays-1)],$countSpec,$spec);

        return $this->render('@RecBundle/Calendar/clndr.html.twig',array(
            'arrDates'=>$arrDates,
            'arrMnt'=>$clMan::arrMnt,
            'arrDNum'=>$clMan::arrDNum,
            'arrDis'=>$arrDis,
            'loc'=>$loc,
            'serv'=>$serv,
            'spec'=>$spec
        ));
    }

    public function dayAction($day) {

        $clMan = $this->get('clndr.manager');
        $specs = $this->getDoctrine()->getRepository(Spec::class)->findAll();
        $arrTime = $clMan->getTimes();
        $arrNVac = $clMan->getArrNVacByDay($specs,$day);

        return $this->render('@RecBundle/Calendar/day.html.twig',array(
            'day'=>$day,
            'specs'=>$specs,
            'arrTime'=>$arrTime,
            'arrNVac'=>$arrNVac
        ));
    }

    public function toRecClAction($serv,$spec) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $serv = $em->getRepository(Serv::class)->find($serv);
        $spec = $em->getRepository(Spec::class)->find($spec);

        return $this->render('@RecBundle/Calendar/toRecClndr.html.twig',array(
            'serv'=>$serv,
            'spec'=>$spec
        ));
    }

    public function toRecDayAction($serv,$spec,$dt) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $clMan = $this->get('clndr.manager');

        $serv = $em->getRepository(Serv::class)->find($serv);
        $spec = $em->getRepository(Spec::class)->find($spec);

        $times = $clMan->getTimes();
        $usesTimes = $clMan->getSpecArrNvacByDay($spec,$dt);

        $finalTimes = array();

        foreach($times as $v) {
            if(!in_array($v,$usesTimes))
                $finalTimes[] = $v;
        }

        return $this->render('@RecBundle/Calendar/toRecDay.html.twig',array(
            'serv'=>$serv,
            'spec'=>$spec,
            'dt'=>$dt,
            'freeTimes'=>$finalTimes
        ));
    }

    public function resultAction($rid) {
        $rec = $this->getDoctrine()->getRepository(Record::class)->findOneBy(array('uuid'=>$rid));

        return $this->render('@RecBundle/Calendar/result.html.twig',array(
            'rec'=>$rec
        ));
    }
}