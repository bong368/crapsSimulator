<?php

namespace JayCasino\Game\Craps;

use JayCasino\Game\Common\Dice;

/**
 * Singleton PassChip Class 
 * PassChip is the chip used in craps game which is either On or Off.
 * All the methods are used to find status for this.
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class PassChip
{

    private static $instance = NULL;

    private $status = 'off';

    private $value = 0;

    /**
     * Instantiate PassChip, default value is Off
     * This is private so it can't be instantiated outside this class
     */
    private function __construct()
    {
        $this->status = 'off';
        $this->value = 0;
    }

    /**
     * Get PassChip instance
     *
     * @return PassChip
     */
    public static function getInstance()
    {
        if (static::$instance == NULL)
        {
            static::$instance = new PassChip();
        }
        return static::$instance;
    }

    /**
     * Get Status
     *
     * @return string
     */
    private function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status
     *
     * @param string $status
     * @return \JayCasino\Game\Craps\PassChip
     */
    private function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }

    /**
     * Get Value
     *
     * @return integer
     */
    private function getValue()
    {
        return $this->value;
    }

    /**
     * Set Value
     * 
     * @param integer $value
     * @return \JayCasino\Game\Craps\PassChip
     */
    private function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public static function status()
    {
        return static::getInstance()->getStatus();
    }

    /**
     * Set status to off
     *
     * @return \JayCasino\Game\Craps\PassChip
     */
    public static function off()
    {
        return static::getInstance()->setStatus('off');
    }

    /**
     * Set status to on
     *
     * @return \JayCasino\Game\Craps\PassChip
     */
    public static function on()
    {
        return static::getInstance()->setStatus('on');
    }

    /**
     * If status is on, than this will return value of active number
     * 
     */
    public static function value($value=NULL)
    {
        if ($value !== NULL)
        {
            static::getInstance()->setValue($value);
            return $value;
        }
        else
        {
            return static::getInstance()->getValue();
        }
    }

    /**
     * Adjust value and status of PassChip instance to dice values and current instance status
     * 
     * @param \JayCasino\Game\Craps\Dice $dice1
     * @param \JayCasino\Game\Craps\Dice $dice2
     */
    public static function adjustToSituation(Dice $dice1, Dice $dice2)
    {
        $diceTotal = $dice1->getValue() + $dice2->getValue();
        if (static::status() == 'on') {
            if ($diceTotal == static::value() || $diceTotal == 7) {
                static::off();
            }
        } else if (static::status() == 'off') {
            if (in_array($diceTotal, array(4,5,6,8,9,10))) {
                static::on();
                static::value($diceTotal);
            }
        }
            
    }
    
    
}