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
$accountNumber = getenv('ACCOUNT_NUMBER');

$client = \Pkj\Sbanken\Client::factory($credentials);

$client->authorize();

$transactionRequest = new \Pkj\Sbanken\Request\TransactionListRequest($accountNumber);
$transactionRequest->setStartDate(new \DateTime('-1 year')); // Just get transactions for the past year. ( max -366 days in sbanken..).

$transactions = $client->Transactions()->getList($transactionRequest);

foreach ($transactions as $transaction){
    echo "{$transaction->accountingDate->format('d.m-Y')}: {$transaction->amount} NOK\n";
}


