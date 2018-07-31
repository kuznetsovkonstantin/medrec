<?php
namespace RecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ServTags")
 */
class ServTags
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Serv", inversedBy="tags")
     * @ORM\JoinColumn(name="serv", referencedColumnName="id")
     */
    private $serv;


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
     * @return ServTags
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
     * Set serv
     *
     * @param \RecBundle\Entity\Serv $serv
     *
     * @return ServTags
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
}
