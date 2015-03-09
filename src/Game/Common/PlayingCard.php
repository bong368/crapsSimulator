<?php
/**
 * Playing Card Class
 * This class is for traditional cards A to K with four suits and Jokers depending on game.
 */
class PlayingCard extends Card
{
    private $suit;
    

    /**
     * New property suit added other than parent properties name and value
     * @param string $name
     * @param string $suit
     * @param int $value
     */
    public function __construct($name, $suit, $value) 
    {
        parent::__construct($name, $value);
        $this->setSuit($suit);
    }
    
    /**
     * Get suit of the card
     * @return string
     */
    public function getSuit()
    {
        return $this->suit;
    }
    
    /**
     * Set suit of the card based on set value
     * @param type $suit
     */
    public function setSuit($suit)
    {
        $this->suit = $suit;
    }
    
    /**
     * Set value of the card
     * @param int $value
     */
    public function setValue($value) 
    {
        $this->value = $value;
    }
    
    /**
     * Set name of the card
     * @param string $name
     */
    public function setName($name) 
    {
        $this->name = $name;
    }
        
    //Magic
    public function __toString() 
    {
        return $this->getSuitUnicode() . ' ' . $this->getName();
    }
    
    public function getSuitUnicode()
    {
        switch ($this->getSuit())
        {
            case 'spades' :
                return '&#9824';
            case 'hearts' :
                return '&#9829';
            case 'diamonds' :
                return '&#9830';
            case 'clubs' :
                return '&#9827';
        }
    }
}