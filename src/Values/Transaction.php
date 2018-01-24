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
    public function __construct(array $properties = array())
    {

        if ($properties['registrationDate'] !== null) {
            $properties['registrationDate'] = new \DateTime($properties['registrationDate']);
        }
        if ($properties['accountingDate'] !== null) {
            $properties['accountingDate'] = new \DateTime($properties['accountingDate']);
        }
        if ($properties['interestDate'] !== null) {
            $properties['interestDate'] = new \DateTime($properties['interestDate']);
        }


        parent::__construct($properties);
    }

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