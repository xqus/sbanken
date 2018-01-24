<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 24.01.2018
 * Time: 23:03
 */

namespace Pkj\Sbanken\Request;


class TransferRequest
{

    /**
     * @var string
     */
    private $fromAccount;

    /**
     * @var string
     */
    private $toAccount;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $message;


    public function __construct(string $fromAccount, string $toAccount, float $amount, string $message)
    {
        $this->fromAccount = $fromAccount;
        $this->toAccount = $toAccount;
        $this->amount = $amount;
        $this->message = $message;
    }


    public function toRequestArray () {
        return [
            'FromAccount' => $this->fromAccount,
            'ToAccount' => $this->toAccount,
            'Amount' => $this->amount,
            'Message' => $this->message
        ];
    }



}