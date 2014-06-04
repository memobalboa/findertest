<?php
/**
 * This file is meant to be called from the CLI using a single argument, which
 * is the screen name of the twitter user that we are going to query, e.g.
 * php twitterUserLookup.php twitterapi
 * 
 */
require_once __DIR__ . '/bootstrap.php';

$configPath = __DIR__ . '/config/config.yml';

if(isset($_SERVER['argv'][1])) { 
    $username = $_SERVER['argv'][1];
    $fetcher = new \FinderTest\Twitter\UserDataFetcher($configPath);
    $data = $fetcher->fetchDataForUser($username);
    print_r($data);
} else {
    echo "Sorry, you need to specify the username you want to look up, e.g. 'twitterUserLookup.php twitterapi' \n";
}