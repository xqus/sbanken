<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 24.01.2018
 * Time: 22:05
 */

namespace Pkj\Sbanken\Endpoint;


use Pkj\Sbanken\Request\TransactionListRequest;
use Pkj\Sbanken\Values\Transaction;

class Transactions
{
    use HasClient;

    const ENDPOINT_LIST = '/bank/api/v1/Transactions/{customerId}/{accountNumber}';


    /**
     * @return \Pkj\Sbanken\Values\Transaction[]|\Pkj\Sbanken\Values\Collection
     */
    public function getList (TransactionListRequest $request) {
        $customArgs = [
            'query' => $request ? $request->toRequestArray() : null
        ];
        $endpoint = str_replace('{accountNumber}', $request->getAccountNumber(), self::ENDPOINT_LIST);
        return $this->client->queryEndpointList('GET', $endpoint, Transaction::class, $customArgs);
    }




}