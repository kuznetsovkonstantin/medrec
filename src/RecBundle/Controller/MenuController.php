<?php

namespace RecBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
    public function getMenuAction()
    {
        $menu = $this->getDoctrine()->getRepository('RecBundle:Menu')->findAll();

        return $this->render('@RecBundle/Default/menu.html.twig',array(
            'menu'=>$menu
        ));
    }
}
