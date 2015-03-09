<?php
namespace JayCasino\Game\Craps;

use JayCasino\Game\Common\BetableSlot;
use JayCasino\Game\Craps\PassChip;
use JayCasino\Game\Common\Dice;

/**
 * HardSlot for numbers 4,6,8,10. Have to create individual objects for each
 * Different HardSlot has different returnRate
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class HardSlot extends BetableSlot
{

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
        if ($this->getBet() > 0 && ($dice1->getValue() == $dice2->getValue()) )
        {
            $diceTotal = $dice1->getValue() + $dice2->getValue();

            if (PassChip::status() == 'on' && $diceTotal == $this->getValue()) {
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
     * @return int
     */
    public function isLoser(Dice $dice1, Dice $dice2)
    {
        //if there is bet on the slot
        if ($this->getBet() > 0 && ($dice1->getValue() != $dice2->getValue()) )
        {
            $diceTotal = $dice1->getValue() + $dice2->getValue();

            if (PassChip::status() == 'on' && $diceTotal == '7') {   
                return true;
            } else if (PassChip::status() == 'on' && $diceTotal == $this->getValue() ) {
                return true;
            }
        }
        return false;
    }
    

}