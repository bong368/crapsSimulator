<?php

namespace JayCasino\Game\Simulator;

use JayCasino\Game\Craps\CrapsGame;
use JayCasino\Game\Craps\PassChip;
use JayCasino\Game\Common\BetableSlot;
use JaysCasino\Game\Common\Output;

/**
 * CrapsSimulator to run craps game for preset of bet preferences
 * 
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class CrapsSimulator
{
    private $maxRollCount = 1; //maximum roll count
    private $totalChips = 1000;
    
    private $currentRollCount = 0;

    /**
     * Instantiate CrapsSimulator with defaults
     * 
     * @param int $totalChips
     * @param int $maxRollCount
     */
    public function __construct($totalChips=1000, $maxRollCount=1) 
    {
        $this->totalChips = $totalChips;
        $this->maxRollCount = $maxRollCount;
    }
    
    /**
     * Start the Craps Simulator, the simulator rules are setin setBets function
     */
    public function start()
    {
        Output::writeLn("Starting Craps with balance " . $this->totalChips);
        //$this->setBets();
        $this->maxRollCount = 100;
        while ($this->currentRollCount < $this->maxRollCount && $this->totalChips > 0) {
            Output::writeLn("************************************");
            Output::writeLn("Roll no " . ($this->currentRollCount + 1) . " Balance: " . $this->totalChips);
            
            $this->setBets();
            $winning = CrapsGame::getInstance()->next();
            Output::writeLn("Total Winning " . $winning);
            
            if ($winning > 0) {
                $this->deposit($winning);
            } else if ($winning < 0) {
                //$this->withdraw(abs($winning));
            }
            //$this->totalChips += $winning;
            $this->currentRollCount++;
            
            Output::writeLn("Roll End Balance: " . $this->totalChips);
        }
        Output::writeLn("Ended Craps with balance " . $this->totalChips);
        
    }
    
    
    /**
     * Rules for the betting, override this method to change your bettings
     * @todo Override this method, or change to set rules for betting for simulator
     */
    public function setBets()
    {
        //if passchip is off
        if (PassChip::status() == 'off') {
            //bet 10 on pass
            $this->adjustBet(CrapsGame::getInstance()->getSlot('pass'), 10);
            //$this->adjustBet(CrapsGame::getInstance()->getSlot('6'), 0);
            //$this->adjustBet(CrapsGame::getInstance()->getSlot('8'), 0);
        } 
        
        if (PassChip::status() == 'on') {
            $this->adjustBet(CrapsGame::getInstance()->getSlot('6'), 12);
            $this->adjustBet(CrapsGame::getInstance()->getSlot('8'), 12);
        }
    }
    
    /**
     * Withdraw chips from balance
     * 
     * @param integer $withdrawAmount
     * @return \JayCasino\Game\Simulator\CrapsSimulator
     */
    public function withdraw($withdrawAmount)
    {
        $this->totalChips = $this->totalChips - $withdrawAmount;
        //Output::writeLn("Withdrawing " . $withdrawAmount);
        return $this;
    }
    
    /**
     * Deposit chips to balance
     * 
     * @param integer $depositAmount
     * @return \JayCasino\Game\Simulator\CrapsSimulator
     */
    public function deposit($depositAmount)
    {
        $this->totalChips = $this->totalChips + $depositAmount;
        //Output::writeLn("Deposit " . $depositAmount);
        return $this;
    }
    
    /**
     * Adjust the bet amount on particular slot
     * 
     * @param \JayCasino\Game\Common\BetableSlot $slot
     * @param integer $adjustAmount
     * @return boolean
     */
    public function adjustBet(BetableSlot $slot, $adjustAmount)
    {
        $currentBet = $slot->getBet();
        //if current bet is more than adjusted bet amount, deposit it back to player balance
        if ($currentBet > $adjustAmount) {         
            Output::writeLn("Depositing " . ($currentBet-$adjustAmount) . " from slot " . $slot->getLabel());
            $this->deposit($currentBet-$adjustAmount);
            $slot->setBet($adjustAmount);
            return true;
        } else if ($adjustAmount > $currentBet) { 
            $difference = $adjustAmount - $currentBet;
            //if player balance is higher than the difference to be paid to table
            if ($this->totalChips > $difference) {
                Output::writeLn("Withdrawing " . $difference . " for slot " . $slot->getLabel());
                $this->withdraw($difference);
                $slot->addBet($difference);
                return true;
            }
        }
        return false;
    }
    
}