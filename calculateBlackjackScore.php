<?php
/**
 * This file is meant to be called from the CLI using two arguments, which are
 * the first and second card in that order... e.g.:
 * php calculateBlackJackScore.php A K
 * php calculateBlackJackScore.php 3 J
 * 
 */
require_once __DIR__ . '/bootstrap.php';

$calculator = new \FinderTest\Blackjack\BlackjackScoreCalculator();

try {
    $a = $_SERVER['argv'][1];
    $b = $_SERVER['argv'][2];
    $score = $calculator->calculateScore($a, $b);    
    echo "The score is $score\n";
} catch (\Exception $ex) {
    echo "There was an error calculating the score, the error was: {$ex->getMessage()}\n";
}