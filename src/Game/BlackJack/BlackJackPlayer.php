<?php
/**
 * BlackJack Player Class
 */
class BlackJackPlayer extends Player
{
    private $cardTotal;
    private $bet;
    /**
     * To check if player is winner,looser,blackjack or push(tie)
     * @var int
     */
    private $rank;

    /**
     * Get the player bet for this game
     * @return int - bet amount
     */
    public function getBet()
    {
        return $this->bet;
    }
    
    /**
     * Get the player bet for this game
     * @param int $bet - set player bet
     */
    public function setBet($bet)
    {
        $this->bet = $bet;
    }
    
    /**
     * Custom card value rule, because in blackjack game player can choose value of 'A'
     * and 'J,Q,K' are 10
     * @param PlayingCard $card
     * @return int - Value of passed Card
     */
    private function cardValueExceptions(PlayingCard $card)
    {
        switch($card->getName())
        {
            case 'J' :
            case 'Q' :
            case 'K' :
                return 10;
            case 'A' :
                return (($this->cardTotal) + 11 > 21) ? '1' : '11';
            default :
                return $card->getValue();
        }
    }
    
    /**
     * Calculate card total, consider exception values for each card
     */
    private function calculateCardTotal()
    {
        $this->cardTotal = 0;
        foreach ($this->getCards() as $card)
        {
            $this->cardTotal += $this->cardValueExceptions($card);
        }
    }
    
    /**
     * Returns sensible total of all cards
     * @return int
     */
    public function getCardTotal()
    {
        $this->calculateCardTotal();
        return $this->cardTotal;
    }
    
    /**
     * Logic if player should get next card or not based on current card total(17 is stop)
     * @return boolean
     */
    public function shouldGetNextCard()
    {
        $total = $this->getCardTotal();
        if ($total < 17)
        {
            return true;
        }
        else if ($total == 17)
        {
            if ($this->hasCardWithName('A')) return true;
            return false;
        }
        return false;
    }
    
    /**
     * Checks if player has card with certain name,
     * In blackjack Suit doesnt play big role so just find by name
     * @param string $name - Name of card to search for
     * @return boolean
     */
    private function hasCardWithName($name)
    {
        if (!is_array($name)) $name = array($name);
        foreach ($this->getCards() as $card)
        {
            if (in_array($card->getName(), $name)) return true;
        }
        return false;
    }
    
    /**
     * Get Player Rank
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }
    
    /**
     * Set rank of player if he is winner, looser, blackjack or push(tie)
     * @param int $rank - Use Enum/Const to set Player::PLAYER_RANK_*
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
    
    
    //Utility methods to check if winner is winner, looser, blackjack or push(tie) -START
    /**
     * Checks weather player is blackjack. Condition is if player has only 2 cards
     * 1 being 'A' and second card either of 'J,Q,K'
     * @return boolean
     */
    public function isBlackJack()
    {
        if (count($this->getCards()) == 2)
        {
            if ($this->hasCardWithName('A'))
            {
                if ($this->hasCardWithName('J','Q','K'))
                {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function isWinner()
    {
        if ($this->getRank() == Player::PLAYER_RANK_WINNER) return true;
        return false;
    }
    
    public function isLooser()
    {
        if ($this->getRank() == Player::PLAYER_RANK_LOOSER) return true;
        return false;
    }
    
    public function isPush()
    {
        if ($this->getRank() == Player::PLAYER_RANK_PUSH) return true;
        return false;
    }
    //Utility methods to check if winner is winner, looser, blackjack or push(tie) -END
    
    public function __toString() 
    {
        $retStr = '';
        if ($this->isBlackJack()) $retStr .= '<b>BLACKJACK</b><br>';
        $retStr .= $this->getName() . '<br>Total:' . $this->getCardTotal() . '<br>';
        return $retStr;
    }
}