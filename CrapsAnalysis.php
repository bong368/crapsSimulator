<?php
namespace JayCasino\Game\Craps;

use JayCasino\Game\Simulator\CrapsSimulator;

/**
 *
 * Entry point for the craps simulator
 * 
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
class CrapsAnalysis
{
	
    /**
     * Run the Craps Simulator
     */
    public static function run()
    {
        $simulator = new CrapsSimulator();

        $simulator->start();
    }
    
}