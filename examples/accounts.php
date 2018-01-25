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
$client = \Pkj\Sbanken\Client::factory($credentials);

$client->authorize();

$accounts = $client->Accounts()->getList();

echo "There are total of {$accounts->getAvailableItems()} bank accounts!\n\n";

foreach ($accounts as $account){
    echo "{$account->accountNumber}: {$account->balance}\n";
}


