<?php
namespace RecBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SpecRepository extends EntityRepository
{
    public function getForIndex($cnt) {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('s')
            ->from('RecBundle:Spec','s')
            ->setFirstResult(0)
            ->setMaxResults($cnt)
            ->getQuery()->getResult();
    }

    public function getCountSpec() {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('count(s.id)')
            ->from('RecBundle:Spec','s')
            ->getQuery()->getSingleScalarResult();
    }
}