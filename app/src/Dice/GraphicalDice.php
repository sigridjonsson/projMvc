<?php

declare(strict_types=1);

namespace App\Dice;

/**
 * Class DiceGraphic.
 */
class GraphicalDice extends Dice
{
    const SIDES = 6;

    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function graphic()
    {
        return "dice-" . $this->getLastRoll();
    }
}
