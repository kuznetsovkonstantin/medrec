<?php
namespace RecBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Spec;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RecBundle\Form\SpecType;
use Symfony\Component\HttpFoundation\File\File;
use RecBundle\Entity\Serv;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SpecController extends Controller
{
    public function showListAction() {

        $specs = $this->getDoctrine()->getRepository('RecBundle:Spec')->findAll();

        return $this->render('@RecBundle/Spec/list.html.twig', array(
            'specs' => $specs,
            'specsImg' => $this->getParameter('spec_img')
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function addEditAction(Request $request,$specId = null) {

        if(is_null($specId))
            $spec = new Spec();
        else
            $spec = $this->getDoctrine()->getRepository(Spec::class)->find($specId);

        if (empty($spec))
            throw new Exception('Такого специалиста не существует');

        $flMan = $this->container->get('file.manager');
        $servMan = $this->container->get('serv.manager');
        $specMan = $this->container->get('spec.manager');

        $pathUrl = $this->get('kernel')->getProjectDir() . '/web' . $this->getParameter('spec_img');
        $oldFileName = $spec->getImg();
        $serv = $this->getDoctrine()->getRepository(Serv::class)->findAll();

        if(!is_null($oldFileName))
            $spec->setImg(new File($pathUrl . $spec->getImg()));

        $specForm = $this->createForm(SpecType::class,$spec);
        $specForm->handleRequest($request);

        if($specForm->isSubmitted() && $specForm->isValid()) {

            $flMan->handleImg($spec,$pathUrl,$oldFileName);

            $servsTagCol = $servMan->getArrayColl(json_decode($request->get('specServJSON')));
            $specMan->specServHandle($servsTagCol,$spec);

            $this->getDoctrine()->getManager()->persist($spec);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Данные успешно сохранены");

            return $this->redirectToRoute('specEdit', array('specId' => $spec->getId()));
        }

        return $this->render('@RecBundle/Spec/form.html.twig',array(
            'specForm'=>$specForm->createView(),
            'specId'=>$specId,
            'oldFileName'=>$oldFileName,
            'serv'=>$serv
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function delAction($specId) {
        $spec = $this->getDoctrine()->getRepository(Spec::class)->find($specId);

        try {
            $this->getDoctrine()->getManager()->remove($spec);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spec');
        }
        catch(Exception $e) {
            $this->addFlash("errors", "Невозможно удалить специалиста");
            return $this->redirectToRoute('specEdit', array('specId' => $specId));
        }

    }

    public function getSpecListRecAction($serv) {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Serv $serv */
        $serv = $em->getRepository(Serv::class)->find($serv);
        $specList = $serv->getSpec();

        return $this->render('@RecBundle/Spec/shList.html.twig', array(
            'specList' => $specList,
            'serv' => $serv
        ));
    }
}

