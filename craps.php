<?php

require_once 'CrapsAutoLoader.php';
require_once 'CrapsAnalysis.php';


//run craps
JayCasino\Game\Craps\CrapsAnalysis::run();

JaysCasino\Game\Common\Output::flush();







?>