<?php
/**
 * Making balance an interface as winning and loosing amount differs game to game
 */
interface Balance
{
    public function adjustBalance(Player $player);
    public function addToBalance(Player $player, $bet);
    public function substractFromBalance(Player $player, $bet);
}