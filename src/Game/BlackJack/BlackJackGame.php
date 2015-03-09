<?php
/**
 * BlackJack Game Class
 * Singleton class so we dont have two instance of game and can't mistakely reset values
 */
class BlackJackGame extends Game implements Balance
{
 
    /**
     * Singleton BlackJackGame Instance
     * @var BlackJackGame
     */
    private static $instance = NULL;
    
    /* $dealer BlackJackPlayer */
    private $dealer;
    
    /**
     * 
     * @param PlayingCardDeck $deck
     */
    private function __construct(PlayingCardDeck $deck) 
    {
        $this->setStatus(Game::GAME_STATUS_OPEN);
        $this->deck = $deck;
    }

    /**
     * 
     * @param PlayingCardDeck $deck
     * @return BlackJackGame
     */
    public static function getInstance(PlayingCardDeck $deck)
    {
        if (static::$instance === NULL)
        {
            static::$instance = new BlackJackGame($deck);
        }
        return static::$instance;
    }
    
    /**
     * Returns the dealer player
     * @return BlackJackPlayer
     */
    public function getDealer()
    {
        return $this->dealer;
    }
    
    /**
     * Add Dealer player to the game
     * @param BlackJackPlayer $dealer
     */
    public function addDealer(BlackJackPlayer $dealer)
    {
        $this->dealer = $dealer;
    }
    
    /**
     * Start the blackjack game by distributing 1 card to dealer and each players
     */
    public function start() 
    {
        $this->getDeck()->shuffle();
        $this->getDealer()->addCard($this->getDeck()->next());
        //first round - each player gets a card
        foreach ($this->getPlayers() as $player)
        {
            /* @var $player Player */
            $player->addCard($this->getDeck()->next());
        }
    }
    
    /**
     * Go through each player and serve card until 17 is reached
     */
    public function next()
    {
        //second round - each player except dealer will get cards until they reach 17
        foreach ($this->getPlayers() as $player)
        {
            /* @var $player BlackJackPlayer */
            while ($player->shouldGetNextCard())
            {
                $player->addCard($this->getDeck()->next());
            }
        }
        //dealer will keep getting card until 17 is reached
        while ($this->getDealer()->shouldGetNextCard())
        {
            $this->getDealer()->addCard($this->getDeck()->next());
        }
    }
    
    /**
     * All rounds are completed now, check for winners and adjust balance of each player
     */
    public function end()
    {
        $this->checkWinners();
        $this->setStatus(Game::GAME_STATUS_ENDED);
    }
    
    /**
     * Check for winners and assign rank to each players accordingly
     */
    public function checkWinners() 
    {
        $dealerBlackJack = $this->getDealer()->isBlackJack();
        $dealerCardTotal = $this->getDealer()->getCardTotal();
        foreach ($this->getPlayers() as $player)
        {
            /* @var $player BlackJackPlayer */
            $playerCardTotal = $player->getCardTotal();
            if ($playerCardTotal <= 21)
            {
                if ($playerCardTotal == $dealerCardTotal) 
                {
                    $player->setRank (Player::PLAYER_RANK_PUSH);
                }
                else if ($playerCardTotal < $dealerCardTotal && $dealerCardTotal < 22)
                {
                    $player->setRank(Player::PLAYER_RANK_LOOSER);
                }
                else    
                {
                    $player->setRank(Player::PLAYER_RANK_WINNER);
                }
            }
            else
            {
                $player->setRank (Player::PLAYER_RANK_LOOSER);
            }
            $this->adjustBalance($player);
        }
    }
    
    /**
     * Returns array with player name, total and player cards
     */
    public function getResults()
    {
        $playerTotals = array();
        $playersAndDealer = array_merge(array($this->getDealer()), $this->getPlayers());
        foreach ($playersAndDealer as $player)
        {
            /* @var $player BlackJackPlayer */
            $playerTotals[$player->getName()] = array(
                'cards' => $player->getCards(),
                'total' => $player->getCardTotal()
            );
        }
        return $playerTotals;
    }
    
    /**
     * Adjust balance of player
     * @param Player $player
     */
    public function adjustBalance(Player $player) {
        $bet = $player->getBet();
        $this->addToBalance($player, $bet);
        $this->substractFromBalance($player, $bet);
    }
    
    /**
     * From interface Balance - Add to balance if player is winner or blackjack
     * @param Player $player
     * @param int $bet - Amount of bet
     */
    public function addToBalance(Player $player, $bet) 
    {
        if ($player->isBlackJack() && !$player->isPush()) $player->addBalance ($bet + ($bet/2));
        if ($player->isWinner() && !$player->isBlackJack()) $player->addBalance ($bet);
        //if ($player->isPush()) $player->addBalance ($bet);
    }
    
    /**
     * From interface Balance - Substract from player balance if player is looser
     * @param Player $player
     * @param int $bet - Amount of bet
     */
    public function substractFromBalance(Player $player, $bet) 
    {
        if ($player->isLooser()) $player->substractBalance($bet);
    }
}