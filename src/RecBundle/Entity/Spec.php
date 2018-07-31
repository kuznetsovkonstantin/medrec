<?php
namespace RecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="RecBundle\Repository\SpecRepository")
 * @ORM\Table(name="Spec")
 */
class Spec
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message = "Не заполнено ФИО специалиста")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Не заполнено описание")
     */
    private $body;

    /**
     * @ORM\Column(type="string", nullable = true)
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity="Serv", inversedBy="spec")
     * @ORM\JoinTable(name="SpecServ")
     */
    private $serv;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="spec")
     */
    private $records;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->serv = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Spec
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Spec
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Spec
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Add serv
     *
     * @param \RecBundle\Entity\Serv $serv
     *
     * @return Spec
     */
    public function addServ(\RecBundle\Entity\Serv $serv)
    {
        $this->serv[] = $serv;

        return $this;
    }

    /**
     * Remove serv
     *
     * @param \RecBundle\Entity\Serv $serv
     */
    public function removeServ(\RecBundle\Entity\Serv $serv)
    {
        $this->serv->removeElement($serv);
    }

    /**
     * Get serv
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServ()
    {
        return $this->serv;
    }

    /**
     * Set records
     *
     * @param \RecBundle\Entity\Record $records
     *
     * @return Spec
     */
    public function setRecords(\RecBundle\Entity\Record $records = null)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * Get records
     *
     * @return \RecBundle\Entity\Record
     */
    public function getRecords()
    {
        return $this->records;
    }
}
