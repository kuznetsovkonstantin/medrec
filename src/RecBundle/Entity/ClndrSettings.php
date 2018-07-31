<?php
namespace RecBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ClndrSettings")
 */
class ClndrSettings
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Не заполнено кол-во приемных дней")
     * @Assert\Range(
     *  min = 5,
     *  max = 31,
     *  minMessage = "Минимальное кол-во дней: {{ limit }}",
     *  maxMessage = "Максимальное кол-во дней: {{ limit }}"
     * )
     */
    private $countDays;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Не заполнено кол-во приемных часов")
     * @Assert\Range(
     *  min = 5,
     *  max = 16,
     *  minMessage = "Минимальное кол-во часов: {{ limit }}",
     *  maxMessage = "Максимальное кол-во часов: {{ limit }}"
     * )
     */
    private $countHours;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message = "Не заполнено время начала работы")
     */
    private $startTime;

    /**
     * Set countDays
     *
     * @param integer $countDays
     *
     * @return ClndrSettings
     */
    public function setCountDays($countDays)
    {
        $this->countDays = $countDays;

        return $this;
    }

    /**
     * Get countDays
     *
     * @return integer
     */
    public function getCountDays()
    {
        return $this->countDays;
    }

    /**
     * Set countHours
     *
     * @param integer $countHours
     *
     * @return ClndrSettings
     */
    public function setCountHours($countHours)
    {
        $this->countHours = $countHours;

        return $this;
    }

    /**
     * Get countHours
     *
     * @return integer
     */
    public function getCountHours()
    {
        return $this->countHours;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return ClndrSettings
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
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
}
