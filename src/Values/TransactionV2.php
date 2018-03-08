<?php
namespace Pkj\Sbanken\Values;

/**
 * See API documentation for details: https://api.sbanken.no/Bank/swagger/#!/GET/ApiV2TransactionsByCustomerIdByAccountNumberGet
 *
 * @property-read string $transactionId
 * @property-read \DateTime $accountingDate
 * @property-read \DateTime $interestDate
 * @property-read string $otherAccountNumber
 * @property-read bool $otherAccountNumberSpecified
 * @property-read float $amount
 * @property-read string $text
 * @property-read string $transactionType
 * @property-read float $transactionTypeCode
 * @property-read string $transactionTypeText
 * @property-read bool $isReservation
 * @property-read string/enum $reservationType Enum containing ['notReservation', 'visaReservation', 'purchaseReservation', 'atmReservation']
 * @property-read string/enum $source Enum containing ['accountStatement', 'archive']
 * @property-read TransactionV2CardDetails $cardDetails Optionally contains details about the transaction. See cardDetailsSpecified
 * @property-read bool $cardDetailsSpecified
 *
 * @package Pkj\Sbanken\Values
 */
class TransactionV2 extends ValueObject
{
    public function __construct(array $properties = array())
    {
        if ($properties['accountingDate'] !== null) {
            $properties['accountingDate'] = new \DateTime($properties['accountingDate']);
        }
        if ($properties['interestDate'] !== null) {
            $properties['interestDate'] = new \DateTime($properties['interestDate']);
        }

        if ($properties['cardDetailsSpecified']) {
            $properties['cardDetails'] = new TransactionV2CardDetails((array) $properties['cardDetails']);
        }

        parent::__construct($properties);
    }

    // Note: not described in API documentation. Bug filed: https://github.com/Sbanken/api-examples/issues/13
    protected $transactionId;

    protected $accountingDate;

    protected $interestDate;

    protected $otherAccountNumber;

    protected $otherAccountNumberSpecified;

    protected $amount;

    protected $text;

    protected $transactionType;

    protected $transactionTypeCode;

    protected $transactionTypeText;

    protected $isReservation;

    protected $reservationType;

    protected $source;

    protected $cardDetails;

    protected $cardDetailsSpecified;
}