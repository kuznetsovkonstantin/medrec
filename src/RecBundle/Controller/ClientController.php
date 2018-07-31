<?php
namespace RecBundle\Controller;

use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Client;
use RecBundle\Entity\Record;
use RecBundle\Entity\Serv;
use RecBundle\Entity\Spec;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RecBundle\Form\ClientType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    public function clientInfoRecAction(Request $request,$serv,$spec,$dt,$tm) {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $serv = $em->getRepository(Serv::class)->find($serv);
        $spec = $em->getRepository(Spec::class)->find($spec);

        $client = new Client();

        $clientForm = $this->createForm(ClientType::class,$client);

        $clientForm->handleRequest($request);

        if($clientForm->isSubmitted() && $clientForm->isValid()) {
            $checkCl = $em->getRepository(Client::class)->findOneBy(array('phone'=>$client->getPhone()));

            if($checkCl)
                $client = $checkCl;
            else
                $em->persist($client);

            try {
                /** @var Record $rec */
                $rec = $this->get('clndr.manager')->getNewRecord($serv,$spec,new \DateTime($dt),new \DateTime($tm),$client);
                $em->persist($rec);

                $em->flush();

                return $this->redirectToRoute('recFinal',array('rid'=>$rec->getUuid()));
            }
            catch(Exception $e) {
                $this->addFlash('errors',$e->getMessage());
            }
        }

        return $this->render('@RecBundle/Client/toRecClient.html.twig',array(
            'serv'=>$serv,
            'spec'=>$spec,
            'dt'=>$dt,
            'tm'=>$tm,
            'clientForm'=>$clientForm->createView()
        ));
    }
}