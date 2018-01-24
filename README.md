# Sbanken PHP Client for PHP 7.1+

A comprehensive PHP Client for Sbanken API. 

Apis supported:

- Accounts
- Transactions
- Transfers

# Install

Install using composer.

```
composer require pkj/sbanken:^1.0
```

# Usage

See [examples/](https://github.com/peec/sbanken/tree/master/examples) folder in this repo.


# Examples

Make sure you have PHP 7.1+. We do not support lower versions.

Make sure you have signed up for skandiabanken developer and have client id and client secret. See sbanken website for info.

```
git clone git@github.com:peec/sbanken.git
cd sbanken
composer install
cd examples
```

Run the following commands to test. Note to change the environment variables (CLIENT_ID, CLIENT_SECRET, etc.).


### Listing bank accounts

```bash
CLIENT_ID="x" \ 
CLIENT_SECRET="Y" \ 
CUSTOMER_ID="your person number" \ 
php accounts.php
```


### Listing a specific bank account by account number

```bash
ACCOUNT_NUMBER="11 digit bank account number" \ 
CLIENT_ID="x" \ 
CLIENT_SECRET="Y" \ 
CUSTOMER_ID="your person number" \ 
php single-account.php
```


### Listing transactions for a given bank account number

```bash
ACCOUNT_NUMBER="11 digit bank account number" \ 
CLIENT_ID="x" \ 
CLIENT_SECRET="Y" \ 
CUSTOMER_ID="your person number" \ 
php transactions.php
```


### Transfer KR 1 NOK to some account

```bash
FROM="11 digit bank account number" \ 
TO="11 digit bank account number" \
MONEY="1" \
CLIENT_ID="x" \ 
CLIENT_SECRET="Y" \ 
CUSTOMER_ID="your person number" \ 
php transactions.php
```

