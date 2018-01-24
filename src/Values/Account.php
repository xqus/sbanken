<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 22.01.2018
 * Time: 21:27
 */

namespace Pkj\Sbanken\Values;


/**
 * Class Account
 *
 *
 * @property-read int $accountNumber
 * @property-read int $customerId
 * @property-read int $ownerCustomerId
 * @property-read string $name
 * @property-read string $accountType
 * @property-read boolean $available
 * @property-read float $balance
 * @property-read float $creditLimit
 * @property-read boolean $defaultAccount
 *
 * @package Pkj\Sbanken\Values
 */
class Account extends ValueObject
{

    protected $accountNumber;

    protected $customerId;

    protected $ownerCustomerId;

    protected $name;

    protected $accountType;

    protected $available;

    protected $balance;

    protected $creditLimit;

    protected $defaultAccount;



}