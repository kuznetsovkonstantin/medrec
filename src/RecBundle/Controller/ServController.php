<?php
namespace RecBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Serv;
use RecBundle\Entity\ServTags;
use RecBundle\Entity\Spec;
use RecBundle\Services\FileManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use RecBundle\Form\ServType;


class ServController extends Controller
{
    public function showListAction() {

        $servs = $this->getDoctrine()->getRepository('RecBundle:Serv')->findAll();

        return $this->render('@RecBundle/Serv/list.html.twig', array(
            'servs' => $servs,
            'servsImg'=>$this->getParameter('serv_img')
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function addEditAction(Request $request,$servId = null) {

        if (is_null($servId))
            $serv = new Serv();
        else
            $serv = $this->getDoctrine()->getRepository('RecBundle:Serv')->find($servId);

        if (empty($serv))
            throw new Exception('Услуга не существует');

        $servMan = $this->container->get('serv.manager');
        $flMan = $this->container->get('file.manager');
        $pathUrl = $this->get('kernel')->getProjectDir() . '/web' . $this->getParameter('serv_img');
        $exTags = $servMan->getExsistTagsFile($serv);
        $oldFilename = $serv->getImg();
        $checkBig = $servMan->checkBigIsset();

        if(!is_null($servId))
            $serv->setImg(new File($pathUrl . $serv->getImg()));

        $srvForm = $this->createForm(ServType::class, $serv);
        $srvForm->handleRequest($request);

        if ($srvForm->isSubmitted() && $srvForm->isValid()) {

            $flMan->handleImg($serv,$pathUrl,$oldFilename);
            $servMan->removeTags($serv,$exTags);

            $em = $this->getDoctrine()->getManager();
            $em->persist($serv);
            $em->flush();

            $this->addFlash("success", "Данные успешно сохранены");

            return $this->redirectToRoute('servEdit', array('servId' => $serv->getId()));
        }

        return $this->render('@RecBundle/Serv/form.html.twig', array(
            'srvForm' => $srvForm->createView(),
            'servId' => $servId,
            'reqfile' => is_null($servId)? true : false,
            'oldFilename'=>$oldFilename,
            'checkBig'=>$checkBig
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function delAction($servId) {
        $serv = $this->getDoctrine()->getRepository('RecBundle:Serv')->find($servId);

        if(!empty($serv)) {
            $this->getDoctrine()->getManager()->remove($serv);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('serv');
        }


        $this->addFlash("errors", "Невозможно удалить услугу");
        return $this->redirectToRoute('servEdit', array('servId' => $servId));

    }

    public function getSevListRecAction($spec = null,$dt = null,$tm = null) {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if(is_null($spec))
            $servList = $em->getRepository(Serv::class)->findAll();
        else {

            /** @var Spec $spec */
            $spec = $em->getRepository(Spec::class)->find($spec);

            $servList = $spec->getServ();
        }

        return $this->render('@RecBundle/Serv/shList.html.twig', array(
            'servList' => $servList,
            'spec' => $spec,
            'dt'=>$dt,
            'tm'=>$tm
        ));
    }
}