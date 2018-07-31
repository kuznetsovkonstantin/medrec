<?php
namespace RecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RecBundle\Repository\RecordRepository")
 * @ORM\Table(name="Record")
 */
class Record
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="Spec")
     * @ORM\JoinColumn(name="spec", referencedColumnName="id")
     */
    private $spec;

    /**
     * @ORM\ManyToOne(targetEntity="Serv")
     * @ORM\JoinColumn(name="serv", referencedColumnName="id")
     */
    private $serv;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $uuid;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Record
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Record
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set spec
     *
     * @param \RecBundle\Entity\Spec $spec
     *
     * @return Record
     */
    public function setSpec(\RecBundle\Entity\Spec $spec = null)
    {
        $this->spec = $spec;

        return $this;
    }

    /**
     * Get spec
     *
     * @return \RecBundle\Entity\Spec
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * Set client
     *
     * @param \RecBundle\Entity\Client $client
     *
     * @return Record
     */
    public function setClient(\RecBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \RecBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set serv
     *
     * @param \RecBundle\Entity\Serv $serv
     *
     * @return Record
     */
    public function setServ(\RecBundle\Entity\Serv $serv = null)
    {
        $this->serv = $serv;

        return $this;
    }

    /**
     * Get serv
     *
     * @return \RecBundle\Entity\Serv
     */
    public function getServ()
    {
        return $this->serv;
    }

    /**
     * Set uuid
     *
     * @param string $uuid
     *
     * @return Record
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
