<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="histogram")
 */
class Histogram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $hgId;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $dices;

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
    protected $game;

    public function getId()
    {
        return $this->hgId;
    }

    public function getDices()
    {
        return $this->dices;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function setDices($dices)
    {
        $this->dices = $dices;
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

    public function setGame($game)
    {
        $this->game = $game;
    }
}
