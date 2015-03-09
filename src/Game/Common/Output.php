<?php
namespace JaysCasino\Game\Common;

class Output
{
    
    private static $buffer = "";
    
    public static function writeLn($text)
    {
        static::$buffer .= $text . "<br/>";
    }
    
    public static function write($text)
    {
        static::$buffer .= $text;
    }
    
    public static function flush()
    {
        ob_start();
        print_r(static::$buffer);
        ob_end_flush();
    }
    
}