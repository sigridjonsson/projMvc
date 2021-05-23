<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="highscore")
 */
class Highscore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $hsId;

    /**
     * @ORM\Column(type="int")
     * @var int
     */
    protected $score;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $userName;

    public function getId()
    {
        return $this->hsId;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function setDate()
    {
        $time = new \DateTime("now");
        $this->date = $time->format('d/m/Y H:i:s');
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }
}
