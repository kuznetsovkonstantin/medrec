<?php
namespace RecBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Serv;
use RecBundle\Entity\ServTags;


class ServManager {

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getExsistTagsFile(Serv $serv) {

        $exTags = new ArrayCollection();

        foreach($serv->getTags() as $tag) {
            $exTags->add($tag);
        }

        return $exTags;
    }

    public function removeTags(Serv $serv,$exTags) {
        /** @var ServTags $tag */
        foreach ($exTags as $tag) {
            if (false === $serv->getTags()->contains($tag)) {
                $tag->getServ()->removeTag($tag);
                $this->em->remove($tag);
            }
        }
    }

    public function checkBigIsset() {
        $servBig = $this->em->getRepository('RecBundle:Serv')->findOneBy(array('big'=>true));

        if(empty($servBig))
            return true;
        else
            return false;
    }

    public function getArrayColl(array $ids) {
        $servsTagCol = new ArrayCollection();
        $servsTag = $this->em->getRepository(Serv::class)->findBy(array('id'=>$ids));

        foreach($servsTag as $v) {
            $servsTagCol->add($v);
        }

        return $servsTagCol;
    }

}