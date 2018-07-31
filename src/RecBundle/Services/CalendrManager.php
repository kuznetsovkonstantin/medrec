<?php
namespace RecBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use RecBundle\Entity\Client;
use RecBundle\Entity\ClndrSettings;
use RecBundle\Entity\Record;
use RecBundle\Entity\Serv;
use RecBundle\Entity\Spec;
use Symfony\Component\Config\Definition\Exception\Exception;

class CalendrManager {

    private $em;
    const arrMnt = array('','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
    const arrDNum = array('Вс','Пн','Вт','Ср','Чт','Пт','Сб');
    public $countDays;
    public $countHours;
    public $startTime;

    public function __construct(EntityManager $em) {
        $this->em = $em;

        /** @var ClndrSettings $settings */
        $settings = $this->em->getRepository(ClndrSettings::class)->find(1);

        $this->countDays = $settings->getCountDays();
        $this->countHours = $settings->getCountHours();
        $this->startTime= $settings->getStartTime();
    }

    public function getArrDis($start,$end,$countSpec,$spec = null) {

        $records = $this->em->getRepository(Record::class)->getDisDates($start,$end,$this->countHours,$countSpec);

        $arrDis = array();
        /** @var Record $rec */
        foreach($records as $rec) {
            $arrDis[] = $rec->getDate()->format('d.m.Y');
        }

        return $arrDis;
    }

    public function getDates() {
        $arrDates = array();
        $date = new \DateTime();

        for($i=0;$i<$this->countDays;$i++) {
            $arrDates[] = $date->format('d.m.Y');
            $date->modify('+1 day');
        }

        return $arrDates;
    }

    public function getTimes() {
        $arrTime = array();
        $sTime = $this->startTime;
        for($i = 0;$i <= $this->countHours;$i++) {
            $arrTime[] = $sTime->format('H:i');
            $sTime->modify('+1 hour');
        }

        return $arrTime;
    }

    public function getSpecArrNvacByDay($spec,$day) {
        $rec = $this->em->getRepository(Record::class)->findBy(array('date'=>new \DateTime($day),'spec'=>$spec));

        $arrV = array();

        /** @var Record $rr */
        foreach($rec as $rr) {
            $arrV[] = $rr->getTime()->format('H:i');
        }

        return $arrV;
    }

    public function getArrNVacByDay($specs,$day) {

        $arrNVac = array();

        /** @var Spec $sp */
        foreach($specs as $sp) {
            $arrNVac[$sp->getId()] = $this->getSpecArrNvacByDay($sp,$day);
        }

        return $arrNVac;
    }

    private function checkFreeTime(Spec $spec,$dt,$tm) {
        $rec = $this->em->getRepository(Record::class)->findOneBy(array('date'=>$dt,'time'=>$tm,'spec'=>$spec));

        if($rec)
            return true;
        else
            return false;
    }

    public function getNewRecord(Serv $serv, Spec $spec,$dt,$tm, Client $client) {
        if($this->checkFreeTime($spec,$dt,$tm))
            throw new Exception('К сожалению выбранное время уже занято');

        $rec = new Record();
        $rec->setServ($serv);
        $rec->setSpec($spec);
        $rec->setClient($client);
        $rec->setDate($dt);
        $rec->setTime($tm);
        $rec->setUuid(uniqid());

        return $rec;
    }


}