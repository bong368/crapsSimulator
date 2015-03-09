<?php

require_once 'AutoLoader.php';

$deck = new PlayingCardDeck();
$deck->shuffle();

$dealer = new BlackJackPlayer('Dealer','99999');
$player1 = new BlackJackPlayer('User1','500');
$player2 = new BlackJackPlayer('User2','300');
$player3 = new BlackJackPlayer('User3','400');
$player1->setBet(25);
$player2->setBet(25);
$player3->setBet(25);

$blackJackGame = BlackJackGame::getInstance($deck);
if ($blackJackGame->isRunning() === false)
{
    $blackJackGame->addDealer($dealer);
    $blackJackGame->addPlayer($player1);
    $blackJackGame->addPlayer($player2);
    $blackJackGame->addPlayer($player3);
}

$blackJackGame->start();
$blackJackGame->next();
$blackJackGame->end();

$playersAndDealer = array_merge(array($blackJackGame->getDealer()), $blackJackGame->getPlayers());
foreach ($playersAndDealer as $player)
{
    echo "<br>********************<br>";
    if ($player->isWinner()) echo  "<b>Winner</b>";
    echo $player;
    foreach ($player->getCards() as $card)
    {
        echo $card . "<br>";
    }
    echo $player->getBalance();
}

