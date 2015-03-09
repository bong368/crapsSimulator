<?php
/**
 * Playing Card Deck Class
 * Contains traditional 52 card games by default, jokers can be added by arguments in construct
 * also multiple decks can be created by argument in construct
 */
class PlayingCardDeck extends CardDeck
{
    private static $deckCardSuits = array('spades', 'hearts', 'diamonds', 'clubs');
    private static $deckCards = array(
        1 => array('name'=>'A'),
        2 => array('name'=>'2'),
        3 => array('name'=>'3'),
        4 => array('name'=>'4'),
        5 => array('name'=>'5'),
        6 => array('name'=>'6'),
        7 => array('name'=>'7'),
        8 => array('name'=>'8'),
        9 => array('name'=>'9'),
        10 => array('name'=>'10'),
        11 => array('name'=>'J'),
        12 => array('name'=>'Q'),
        13 => array('name'=>'K'),
    );
    
    /**
     * Create deck of Playing Cards
     * @param int $deckCounts - if needed more than 1 deck
     * @param int $includeJoker - if needed jokers in deck
     */
    public function __construct($deckCounts=1, $includeJoker=0) 
    {
        parent::__construct();
        $this->generate($deckCounts);
        if (is_int($includeJoker) && $includeJoker > 0) $this->includeJokers ($numberOfJokers);
    }

    /**
     * Logic to generate deck
     * @param int $deckCounts - number of decks
     */
    public function generate($deckCounts=1) 
    {
        //loop for number of decks
        for ($i=1;$i<=$deckCounts;$i++)
        {
            //loop for deck card names
            foreach (static::$deckCards as $i=>$card)
            {
                //loop for deck suits
                foreach (static::$deckCardSuits as $suit)
                {
                    $this->addCard(new PlayingCard($card['name'], $suit, $i));
                }
            }
        }
    }
    
    /**
     * Logic to add number of Jokers required in deck
     * @param int $numberOfJokers
     */
    private function includeJokers($numberOfJokers)
    {
        //loop for numbers of joker required
        for($i=1;$i<=$numberOfJokers;$i++)
        {
            $this->addCard(new PlayingCard('Joker','None','None'));
        }
    }
    
    /**
     * Randomize/shuffle the card array so cards are not in the order created
     */
    public function shuffle() {
        parent::shuffle();
    }
    
       
}