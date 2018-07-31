<?php

namespace RecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $servs = $this->getDoctrine()->getRepository('RecBundle:Serv')->findBy(array('top' => 1),array('big'=>'DESC'));
        $specs = $this->getDoctrine()->getRepository('RecBundle:Spec')->getForIndex(4);
        $clnrView = $this->forward('RecBundle:Calendar:getClndr');

        return $this->render('@RecBundle/Default/index.html.twig',array(
            'servs'=>$servs,
            'specs'=>$specs,
            'servsImg'=>$this->getParameter('serv_img'),
            'specsImg'=>$this->getParameter('spec_img'),
            'clnrView'=>$clnrView
        ));
    }
}
