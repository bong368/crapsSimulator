<?php
/**
 * Abstracted Game Class
 * Assuming the Game is Some kind of Card Game
 */
abstract class Game
{
    protected $players = array();
    protected $deck;
    protected $status;
    
    const GAME_STATUS_OPEN = '0';
    const GAME_STATUS_RUNNING = '1';
    const GAME_STATUS_ENDED = '2';
    
    abstract public function start();
    abstract public function checkWinners();
    
    /**
     * Return Status of the Game
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set Status of the Game
     * @param int $status - Use const/Enum Game::GAME_STATUS
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns all the players for the game
     * (For games with dealers we should override this?)
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }
    
    /**
     * Add player to the game
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }
    
    /**
     * Get the CardDeck for the Game
     * @return CardDeck - Deck of Cards
     */
    public function getDeck()
    {
        return $this->deck;
    }
    
    //Utility methods to check Game status - START
    public function isRunning()
    {
        if ($this->getStatus() == static::GAME_STATUS_RUNNING) return true;
        return false;
    }
    
    public function isOpen()
    {
        if ($this->getStatus() == static::GAME_STATUS_OPEN) return true;
        return false;
    }
    
    public function isEnded()
    {
        if ($this->getStatus() == static::GAME_STATUS_ENDED) return true;
        return false;
    }
    //Utility methods to check Game status - END
}