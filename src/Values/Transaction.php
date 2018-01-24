<?php
namespace Pkj\Sbanken\Values;

/**
 * Class Transaction
 *
 * @property-read string $transactionId
 * @property-read string $customerId
 * @property-read string $accountNumber
 * @property-read string $otherAccountNumber
 * @property-read float $amount
 * @property-read string $text
 * @property-read string $transactionType
 * @property-read \DateTime $registrationDate
 * @property-read \DateTime $accountingDate
 * @property-read \DateTime $interestDate
 *
 * @package Pkj\Sbanken\Values
 */
class Transaction extends ValueObject
{
    protected $transactionId;

    protected $customerId;

    protected $accountNumber;

    protected $otherAccountNumber;

    protected $amount;

    protected $text;

    protected $transactionType;

    protected $registrationDate;

    protected $accountingDate;

    protected $interestDate;
}