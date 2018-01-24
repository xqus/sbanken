<?php
require '../vendor/autoload.php';

// WARNING!
// PLEASE BE VERY CAREFUL WITH CLIENT_ID, SECRET AND CUSTOMER_ID
// NEVER STORE THESE IN SCRIPTS. USE BEST PRACTICES AND USE ENVIRONMENT VARIABLES.
$credentials = new \Pkj\Sbanken\Credentials(
    getenv('CLIENT_ID'),
    getenv('CLIENT_SECRET'),
    getenv('CUSTOMER_ID')
);

$fromAccount = getenv('FROM');
$toAccount = getenv('TO');
$money = (float)getenv('MONEY');


$client = \Pkj\Sbanken\Client::factory($credentials);

$client->authorize();

$transfer = new \Pkj\Sbanken\Request\TransferRequest(
    $fromAccount,
    $toAccount,
    $money,
    'Hello World.'
);

var_dump($client->Transfers()->createTransfer($transfer));



