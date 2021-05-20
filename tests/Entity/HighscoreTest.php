<?php

declare(strict_types=1);

namespace App\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Highscore;


/**
 * Test cases for the controller Debug.
 */
class HighscoreTest extends TestCase
{
    /**
     * Check that setScore() and getScore() works.
     */
    public function testScore()
    {
        $controller = new Highscore();
        $controller->setScore(10);

        $exp = 10;
        $res = $controller->getScore();
        $this->assertSame($exp, $res);
    }

    /**
     * Check that setDate() and getDate() works.
     */
    public function testDate()
    {
        $controller = new Highscore();
        $controller->setDate();

        $date = new \DateTime("now");
        $exp = $date->format('d/m/Y H:i:s');
        $res = $controller->getDate();
        $this->assertSame($exp, $res);
    }
}
