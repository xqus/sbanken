<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 24.01.2018
 * Time: 22:05
 */

namespace Pkj\Sbanken\Endpoint;


use Pkj\Sbanken\Request\TransferRequest;
use Pkj\Sbanken\Values\Transaction;

class Transfers
{
    use HasClient;

    const ENDPOINT_CREATE = '/bank/api/v1/Transfers/{customerId}';


    public function createTransfer (TransferRequest $transfer) {
        $customArgs = [
            \GuzzleHttp\RequestOptions::JSON => $transfer->toRequestArray()
        ];
        return $this->client->queryEndpoint('POST', self::ENDPOINT_CREATE, $customArgs);
    }

}