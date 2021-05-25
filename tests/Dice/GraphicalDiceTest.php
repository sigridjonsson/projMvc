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
     * Check that roll() returns the right amount of dices.
     */
    public function testGraphic()
    {
        $controller = new GraphicalDice();
        $controller->roll();

        $exp = "string";
        $res = gettype($controller->graphic());
        $this->assertSame($exp, $res);
    }

    //  /**
    //   * Check that getLastRoll() returns the right dices.
    //   */
    // public function testGetLastRoll()
    // {
    //     $controller = new DiceHand();
    //
    //     $exp = $controller->roll();
    //     $res = $controller->getLastRoll();
    //     $this->assertSame($exp, $res);
    // }
}
