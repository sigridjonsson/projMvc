<?php

declare(strict_types=1);

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Histogram;

/**
 * Test cases for the controller Debug.
 */
class HistogramTest extends TestCase
{
    /**
     * Check that setScore() and getScore() works.
     */
    public function testScore()
    {
        $controller = new Histogram();
        $controller->setScore(10);

        $exp = 10;
        $res = $controller->getScore();
        $this->assertSame($exp, $res);
    }

    /**
     * Check that setDices() and getDices() works.
     */
    public function testDices()
    {
        $controller = new Histogram();
        $controller->setDices("1, 2, 3");

        $exp = "1, 2, 3";
        $res = $controller->getDices();
        $this->assertSame($exp, $res);
    }

    /**
     * Check that setDate() and getDate() works.
     */
    public function testDate()
    {
        $controller = new Histogram();
        $controller->setDate();

        $date = new \DateTime("now");
        $exp = $date->format('d/m/Y H:i:s');
        $res = $controller->getDate();
        $this->assertSame($exp, $res);
    }

    /**
     * Check that setGame() and getGame() works.
     */
    public function testGame()
    {
        $controller = new Histogram();
        $controller->setGame("Yatzy");

        $exp = "Yatzy";
        $res = $controller->getGame();
        $this->assertSame($exp, $res);
    }
}
