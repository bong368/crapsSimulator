<?php

namespace JaysCasino\Game\Common;

/**
 * Betable should be implemented by any game that has area/point where you can bet on
 *
 * @author Jay Gaudani <jaygaudani@gmail.com>
 */
interface Betable {

    public function getValue();

    public function getReturnRate();

    public function setReturnRate();

    public function getLabel();

    public function isWinner(Dice $dice1, Dice $dice2);

    public function setBet($bet);

    public function getBet();
}

