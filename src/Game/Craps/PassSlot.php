<?php

namespace JayCasino\Game\Craps;

use JayCasino\Game\Common\BetableSlot;
use JayCasino\Game\Common\Dice;
use JayCasino\Game\Craps\PassChip;
use JaysCasino\Game\Common\Output;

/**
 * PassSlot is slot for pass bar
 * PassSlot return  is dependent on the status and value of PassChip
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class PassSlot extends BetableSlot
{

    protected $returnRate = 100;

    private static $instance = NULL;

    private static $offWinningNumbers = array(7,11);
    private static $offLoosingNumbers = array(2,3,12);
	
	private static $winningNumbersArray = array(
		4 => 180,
		5 => 140,
		6 => 116.67,
		8 => 116.67,
		9 => 140,
		10 => 180
	);
	
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
        $diceTotal = $dice1->getValue() + $dice2->getValue();
        if ($this->getBet() > 0) {
            if (PassChip::status() == 'off' && in_array($diceTotal, static::$offWinningNumbers)) {
                return true;
            } else if (PassChip::status() == 'on' && PassChip::value() == $diceTotal) {
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
        //if there is bet on the slot
        $diceTotal = $dice1->getValue() + $dice2->getValue();
        if ($this->getBet() > 0) {
            if (PassChip::status() == 'off' && in_array($diceTotal, static::$offLoosingNumbers)) {
                return true;
            }
            if (PassChip::status() == 'on' && $diceTotal == 7) {
                    return true;
            }
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
            $diceTotal = $dice1->getValue() + $dice2->getValue();
            $returnRate = $this->getReturnRate();
            if (PassChip::status() == 'on' && in_array($diceTotal, array_keys(static::$winningNumbersArray))) {
                $returnRate = static::$winningNumbersArray[$diceTotal];
                //Output::writeLn("Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner Winner");
                Output::writeLn("<span style='color: green'><b>Winner " . $diceTotal . "</b></span>");

            }
            $winAmount = ($this->getBet() * ($returnRate/100));
            
            if (PassChip::value() == $diceTotal) {
                //@todo: pass chip amount also wins when on number rolls
            }
            return $winAmount;
        } else if ($this->isLoser($dice1, $dice2)) {
            return ($this->getBet() * -1);
        } else {
            return 0;
        }
    }

}