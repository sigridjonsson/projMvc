<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the controller Debug.
 */
class DiceDiceHandTest extends TestCase
{
    /**
     * Check that roll() returns the right amount of dices.
     */
    public function testRoll()
    {
        $controller = new DiceHand(10);

        $exp = 10;
        $res = count($controller->roll());
        $this->assertSame($exp, $res);
    }

     /**
      * Check that getLastRoll() returns the right dices.
      */
    public function testGetLastRoll()
    {
        $controller = new DiceHand();

        $exp = $controller->roll();
        $res = $controller->getLastRoll();
        $this->assertSame($exp, $res);
    }
}
