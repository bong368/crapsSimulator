<?php

namespace JayCasino\Game\Craps;

use JayCasino\Game\Craps\FieldSlot;
use JayCasino\Game\Craps\SoftSlot;
//use JayCasino\Game\Common\Game;
use JayCasino\Game\Common\Dice;
use JayCasino\Game\Common\BetableSlot;
use JaysCasino\Game\Common\Output;

/**
 * CrapsGame class, it manages all the components of the craps game.
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class CrapsGame
{

    private static $instance = null;
    
    private static $slots = array();
    
    private static $dices = array();
    
    private function __construct() 
    {
        $passChip = PassChip::off();
        $this->prepareSlots();
    }
    
    /**
     * Get CrapsGame instance
     * 
     * @return CrapsGame
     */
    public static function getInstance()
    {
        if (static::$instance == NULL)
        {
            static::$instance = new CrapsGame();
        }
        
        return static::$instance;
    }
    
        /**
     * Roll the dice for craps game, each roll will be caled by this function
     * 
     * @return integer - Winning Amount for this roll in craps
     */
    public function next()
    {
        $dice1 = new Dice('1');
        $dice2 = new Dice('2');
        
        
        Output::writeLn("Pass: " . PassChip::status());
        Output::writeLn("Rolling the Dice " . $dice1->getValue() . "-" . $dice2->getValue());
        Output::writeLn("PassChip value: " . PassChip::value());
        
        $winning = $this->checkWinnings($dice1, $dice2);
        
        //now adjust status of passchip
        PassChip::adjustToSituation($dice1, $dice2);
        return round($winning);
    }

    /**
     * Go through each slot in CrapsGame singleton, and return the total winning amount
     * @param Dice $dice1
     * @param Dice $dice2
     * @return integer
     */
    private function checkWinnings(Dice $dice1, Dice $dice2)
    {
        $winningAmount = 0;
        foreach (static::$slots as $slot) {
            /*@var $slot BetableSlot */
            $slotWinningAmount = $slot->getWinningAmount($dice1, $dice2);
            $slotWinningAmount = round($slotWinningAmount);
            if ($slotWinningAmount > 0) {
                $winningAmount += $slotWinningAmount;
                Output::writeLn("<span style='color:green;'><b>Slot " . $slot->getLabel() . " Bets: " . $slot->getBet() . " Wins: " . $slotWinningAmount . "</b></span>");
            } else if ($slotWinningAmount < 0) {  
                Output::writeLn("<span style='color:red;'><b>Slot " . $slot->getLabel() . ". Bets: " . $slot->getBet() . " Bets Lost.</b></span>");
                $slot->setBet(0);
            } else {
                Output::writeLn("Slot " . $slot->getLabel() . " Bets: " . $slot->getBet());
            }
        }
        
        return $winningAmount;
    }
    
    /**
     * Prepare slots for Craps Game
     */
    private function prepareSlots()
    {
        static::$slots['4'] = new SoftSlot('4', '4', 180);
        static::$slots['5'] = new SoftSlot('5', '5', 140);
        static::$slots['6'] = new SoftSlot('6', '6', 116.67);
        static::$slots['8'] = new SoftSlot('8', '8', 116.67);
        static::$slots['9'] = new SoftSlot('9', '9', 140);
        static::$slots['10'] = new SoftSlot('10', '10', 180);
        
        static::$slots['field'] = new FieldSlot('field', 'field');
        static::$slots['pass'] = new PassSlot('pass', 'pass');
    }

    /**
     * Get slots set for the Craps Game
     * @return BetableSlot[]
     */
    public function getSlots()
    {
        return static::$slots;
    }
    
    /**
     * 
     * @param type $slotValue
     * @return type
     */
    public function getSlot($slotValue='pass')
    {
        return isset(static::$slots[$slotValue]) ? static::$slots[$slotValue] : NULL;
    }
    
    /**
     * Set Bet for the Slot
     * 
     * @param string $slotValue
     * @param integer $betValue
     * @return boolean
     */
    public function setSlotBet($slotValue, $betValue)
    {
        if (isset(static::$slots[$slotValue])) {
            static::$slots[$slotValue]->setBet($betValue);
            return true;
        }
        return false;
    }
    
    /**
     * Get PassChip instance
     * 
     * @return PassChip
     */
    public function getPassChip()
    {
        return PassChip::getInstance();
    }
    

    

}