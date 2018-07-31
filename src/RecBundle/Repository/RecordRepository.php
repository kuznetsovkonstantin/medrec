<?php
namespace RecBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecordRepository extends EntityRepository
{
    public function getDisDates($start,$end,$countH,$countSpec,$spec = null) {
        $dis = $this->getEntityManager()->createqueryBuilder()
            ->select('r')
            ->from('RecBundle:Record','r')
            ->where('r.date >= :dtSt')
            ->andWhere('r.date < :dtEn')
            ->groupBy('r.date')->having('count(r.id) >= :cnt')
            ->setParameters(array('dtSt'=>$start,'dtEn'=>$end,'cnt'=>$countH*$countSpec));

        if(!is_null($spec))
            $dis->andWhere('r.spec = :spec')->setParameter('spec',$spec);



        return $dis->getQuery()->getResult();
    }
}