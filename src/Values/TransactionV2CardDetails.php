<?php
namespace Pkj\Sbanken\Values;

/**
 * See API documentation for details: https://api.sbanken.no/Bank/swagger/#!/GET/ApiV2TransactionsByCustomerIdByAccountNumberGet
 *
 * @property-read string cardNumber
 * @property-read float currencyAmount
 * @property-read float currencyRate
 * @property-read string merchantCategoryCode
 * @property-read string merchantCategoryDescription
 * @property-read string merchantCity
 * @property-read string merchantName
 * @property-read string originalCurrencyCode
 * @property-read \DateTime purchaseDate
 * @property-read string transactionId
 *
 * @package Pkj\Sbanken\Values
 */
class TransactionV2CardDetails extends ValueObject
{
    public function __construct(array $properties = array())
    {
        if ($properties['purchaseDate'] !== null) {
            $properties['purchaseDate'] = new \DateTime($properties['purchaseDate']);
        }

        parent::__construct($properties);
    }

    protected $cardNumber;

    protected $currencyAmount;

    protected $currencyRate;

    protected $merchantCategoryCode;

    protected $merchantCategoryDescription;

    protected $merchantCity;

    protected $merchantName;

    protected $originalCurrencyCode;

    protected $purchaseDate;

    protected $transactionId;
}