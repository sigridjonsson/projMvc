<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class GraphicalDiceTest extends TestCase
{
    /**
     * Check that GraphicalDice() works and graphic() returns a string.
     */
    public function testGraphic()
    {
        $controller = new GraphicalDice();
        $controller->roll();

        $exp = "string";
        $res = gettype($controller->graphic());
        $this->assertSame($exp, $res);
    }
}
