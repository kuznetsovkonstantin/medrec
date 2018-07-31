<?php
namespace RecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Serv", indexes={@ORM\Index(name="top_ind", columns={"top"}),@ORM\Index(name="big_ind", columns={"big"}) } )
 */
class Serv
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "Не заполнено наименование")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Не заполнено описание")
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *  min = 100,
     *  max = 100000,
     *  minMessage = "Минимальная стоимость {{ limit }} руб.",
     *  maxMessage = "Максимальная стоимость {{ limit }} руб"
     * )
     */

    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $top;

    /**
     * @ORM\Column(type="boolean")
     */
    private $big;

    /**
     * @ORM\Column(type="string")
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity="ServTags", mappedBy="serv",cascade={"persist", "remove"})
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="Spec", mappedBy="serv")
     */
    private $spec;


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
     * @return Serv
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
     * @return Serv
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
     * Set price
     *
     * @param integer $price
     *
     * @return Serv
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set top
     *
     * @param boolean $top
     *
     * @return Serv
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return boolean
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Set big
     *
     * @param boolean $big
     *
     * @return Serv
     */
    public function setBig($big)
    {
        $this->big = $big;

        return $this;
    }

    /**
     * Get big
     *
     * @return boolean
     */
    public function getBig()
    {
        return $this->big;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag
     *
     * @param \RecBundle\Entity\ServTags $tag
     *
     * @return Serv
     */
    public function addTag(\RecBundle\Entity\ServTags $tag)
    {

        $tag->setServ($this);
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \RecBundle\Entity\ServTags $tag
     */
    public function removeTag(\RecBundle\Entity\ServTags $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set img
     *
     * @param string $img
     *
     * @return Serv
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
     * Add spec
     *
     * @param \RecBundle\Entity\Spec $spec
     *
     * @return Serv
     */
    public function addSpec(\RecBundle\Entity\Spec $spec)
    {
        $this->spec[] = $spec;

        return $this;
    }

    /**
     * Remove spec
     *
     * @param \RecBundle\Entity\Spec $spec
     */
    public function removeSpec(\RecBundle\Entity\Spec $spec)
    {
        $this->spec->removeElement($spec);
    }

    /**
     * Get spec
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpec()
    {
        return $this->spec;
    }
}
