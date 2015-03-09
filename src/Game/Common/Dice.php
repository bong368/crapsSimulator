<?php

namespace JayCasino\Game\Common;

/**
 * Dice class, used for any game where dice/s are rolled like craps
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class Dice
{
    private $id;

    private $value;

    public function __construct($id)
    {
        $this->id = $id;
        $this->value = rand(1, 6);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function __toString() 
    {
        return $this->value;
    }
    
    

}