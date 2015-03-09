<?php
/**
 * Abstracted CardDeck Class
 * CardDeck is set of Cards with other utility methods required
 */
abstract class CardDeck
{
    private $cards;
    
    /**
     * To make sure carddeck is generated as per the type of card
     */
    abstract function generate();

    /**
     * As this is abstract we only need to set obvious properties, no need of any logic
     */
    public function __construct() 
    {
        $this->cards = array();
    }
    
    /**
     * Add Card to Deck
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        if (!$this->cardExist($card)) $this->cards[] = $card;
    }
    
    /**
     * Remove Card from the deck
     * @param Card $card
     */
    public function removeCard(Card $card)
    {
        $this->cards = array_diff($this->cards, array($card));
    }
    
    /**
     * Get Cards
     * @return Array
     */
    public function getCards()
    {
        return $this->cards;
    }
    
    /**
     * Check if card already exist in the deck
     * @param Card $card
     * @return bool
     */
    public function cardExist(Card $card)
    {
        return in_array($card, $this->getCards());
    }

    /**
     * Utility to shuffle the deck
     */
    public function shuffle()
    {
        shuffle($this->cards);
    }
    
    /**
     * Utility to get next card from the deck
     * @return Card - get next card from the deck
     */
    public function next()
    {
        $randomCard = array_pop($this->cards);
        $this->cards = array_diff($this->cards, array($randomCard));
        return $randomCard;
    }
}