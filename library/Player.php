<?php
/**
 * Generic Player Class
 * Assuming the Player is playing some kind of Card game, with money involved
 */
class Player
{
    protected $name;
    protected $balance;
    protected $cards;
    
    //Enum/const for player rank
    const PLAYER_RANK_UNDECIDED = '0';
    const PLAYER_RANK_LOOSER = '1';
    const PLAYER_RANK_WINNER = '2';
    const PLAYER_RANK_PUSH = '3';
    
    
    /**
     * Instantiate a Player with Name, Balance. And Card if needed
     * @param string $name - Name of Player
     * @param int $balance - Bank Balance of Player
     * @param array $cards - Array of Card objects
     */
    public function __construct($name, $balance, $cards=array()) 
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->cards = $cards;
    }

    /**
     * Get name of player
     * @return string - name of player
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get Balance of player
     * @return int - balance of player
     */
    public function getBalance()
    {
        return $this->balance;
    }
    
    /**
     * Add money to player balance
     * @param int $balance
     */
    public function addBalance($balance)
    {
        $this->balance += $balance;
    }
    
    /**
     * Substract money from player balance
     * @param int $balance
     */
    public function substractBalance($balance)
    {
        $this->balance -= $balance;
    }
    
    /**
     * Set balance to passed amount
     * @param int $balance
     */
    private function setBalance($balance)
    {
        $this->balance = $balance;
    }
    
    /**
     * Add card to player's card stack
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }
    
    /**
     * Get all the cards in player's card stack
     * @return array - Array of Card Objects
     */
    public function getCards()
    {
        return $this->cards;
    }
}