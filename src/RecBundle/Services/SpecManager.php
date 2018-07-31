<?php
namespace RecBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Serv;
use RecBundle\Entity\ServTags;
use RecBundle\Entity\Spec;


class SpecManager {

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    private function removeServs(ArrayCollection $coll,Spec $spec) {
        foreach($spec->getServ() as $servEl) {
            if(false === $coll->contains($servEl))
                $spec->removeServ($servEl);
        }
    }

    private function addServs(ArrayCollection $coll,Spec $spec) {
        foreach($coll as $v) {
            if(false === $spec->getServ()->contains($v))
                $spec->addServ($v);
        }
    }

    public function specServHandle(ArrayCollection $coll,Spec $spec) {
        $this->removeServs($coll,$spec);
        $this->addServs($coll,$spec);
    }

}