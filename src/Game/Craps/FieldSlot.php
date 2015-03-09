<?php

namespace JayCasino\Game\Craps;

use JayCasino\Game\Common\BetableSlot;
use JayCasino\Game\Common\Dice;

/**
 * FieldSlot is slot for field bar
 * FieldSlot bet are always Win or Loose
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class FieldSlot extends BetableSlot
{

    protected $returnRate = 100;

    private static $winningNumbers = array(2,3,4,9,10,11,12);

    /**
     * Is Winner?
     * 
     * @param Dice $dice1
     * @param Dice $dice2
     * @return boolean
     */
    public function isWinner(Dice $dice1, Dice $dice2)
    {
        //if there is bet on the slot
        if ($this->getBet() > 0) {
            $diceTotal = $dice1 + $dice2;

            if (in_array($diceTotal, static::$winningNumbers)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Is Looser?
     * 
     * @param Dice $dice1
     * @param Dice $dice2
     * @return boolean
     */
    public function isLoser(Dice $dice1, Dice $dice2)
    {
        //if there is bet on the slot
        if ($this->getBet() > 0) {
            //if no winner for field bet, than looser
            return ($this->isWinner($dice1, $dice2) === false);
        }

        return false;
    }

    /**
     * Get the winning amount for dice set
     * 
     * @param Dice $dice1
     * @param Dice $dice2
     * @return int
     */
    public function getWinningAmount(Dice $dice1, Dice $dice2)
    {
        $winAmount = 0;
        if ($this->isWinner($dice1, $dice2)) {
            $winAmount = ($this->getBet() * ($this->getReturnRate()/100));
            if ($this->getValue() == 2 || $this->getValue() == 12) {
                $winAmount = $winAmount * 2;
            }
        } else if ($this->isLoser($dice1, $dice2)) {
            
            return ($this->getBet() * -1);
        } else {
            return 0;
        }
    }

}