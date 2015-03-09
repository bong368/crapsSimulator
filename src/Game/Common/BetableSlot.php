<?php
namespace JayCasino\Game\Common;

/**
 * BetableSlot abstract class
 *
 * This defines properties and methods for slot(area on which you put your bet)
 * Specifically coded for Craps Game, but can be used for Roulette
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
abstract class BetableSlot
{

    private $value = false;

    protected $returnRate = 100; //percent value

    private $label = "";

    private $bet = 0;

    /**
     *
     * Instantiate BetableSlot object
     *
     * @param string $label
     * @param string $value
     * @param integer $returnRate
     */
    public function __construct($label, $value, $returnRate=100)
    {
        $this->label = $label;
        $this->value = $value;
        $this->returnRate = $returnRate;
    }

    /**
     * Check if slot is winner or not based on the Dices values
     */
    abstract public function isWinner(Dice $dice1, Dice $dice2);

    /**
     * Check if slot is looser or not based on the Dices values
     */
    abstract public function isLoser(Dice $dice1, Dice $dice2);

    /**
     * Get Value
     *
     * @return string - Value of the bet
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set Value
     *
     * @param string $value
     * @return \BetableSlot
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }


    /**
     * Get returnRate
     *
     * @return integer
     */
    public function getReturnRate()
    {
        return $this->returnRate;
    }

    /**
     * Set returnRate
     *
     * @param integer $returnRate
     * @return \BetableSlot
     */
    public function setReturnRate($returnRate)
    {
        $this->returnRate = $returnRate;

        return $this;
    }

    /**
     * Get Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set Label
     *
     * @param string $label
     * @return \BetableSlot
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get bet amount on this slot
     * 
     * @return integer
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Set bet amount on this slot
     *
     * @param integer $bet
     * @return \BetableSlot
     */
    public function setBet($bet)
    {
        $this->bet = $bet;

        return $this;
    }
    
    /**
     * Clear the bet for the slot, send any bet back to player
     * 
     * @return \JayCasino\Game\Common\BetableSlot
     */
    public function clearBet()
    {
        $this->bet = 0;
        //@todo: return bet to player
        
        return $this;
    }
    
    /**
     * Add passed amount to current bet
     * 
     * @param integer $bet
     * @return \JayCasino\Game\Common\BetableSlot
     */
    public function addBet($bet)
    {
        $this->bet = $this->bet + $bet;
        
        return $this;
    }

    /**
     * Calculate and return winning amount
     * This doesn't include bet amount, it will return pure winning amount
     * If loosing it will return lost amount in negative
     *
     * @param Dice $dice1
     * @param Dice $dice2
     * @return int
     */
    public function getWinningAmount(Dice $dice1, Dice $dice2)
    {
        if ($this->isWinner($dice1, $dice2)) {
            return ($this->getBet() * ($this->getReturnRate()/100));
        } else if ($this->isLoser($dice1, $dice2)) {
            return ($this->getBet() * -1);
        } else {
            return 0;
        }
    }

}