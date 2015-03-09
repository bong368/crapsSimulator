<?php
/**
 * Abstracted Card Class
 * Most of the card games would atleast have name and value property, so abstracting them
 */
abstract class Card
{
    protected $name;
    protected $value;
    
    abstract public function setName($name);
    
    abstract public function setValue($value);
    
    /**
     * Abstracted Class so this can't be instantiated, 
     * but to make children's life easier by avoiding few lines
     * @param type $name
     * @param type $value
     */
    public function __construct($name, $value) 
    {
        $this->setName($name);
        $this->setValue($value);
    }
    
    /**
     * Get Name of the Card
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get Value/Rank of the Card
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    
}