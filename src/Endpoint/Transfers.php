<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 24.01.2018
 * Time: 22:05
 */

namespace Pkj\Sbanken\Endpoint;


class Transfers
{
    use HasClient;

    const ENDPOINT_LIST = 'https://api.sbanken.no/bank/api/v1/Transfers/{customerId}/{accountNumber}';


    public function createTransfer (TransferRequest $transfer) {
        $customArgs = [
            'data' => $request ? $request->toRequestArray() : null
        ];
        $endpoint = str_replace('{accountNumber}', $request->getAccountNumber(), self::ENDPOINT_LIST);
        return $this->client->queryEndpointList('GET', $endpoint, Transaction::class, $customArgs);
    }




}