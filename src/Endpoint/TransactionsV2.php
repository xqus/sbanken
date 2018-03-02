<?php

namespace Pkj\Sbanken\Endpoint;

use Pkj\Sbanken\Request\TransactionV2ListRequest;
use Pkj\Sbanken\Values\TransactionV2;

class TransactionsV2
{
    use HasClient;

    const ENDPOINT_LIST = '/bank/api/v2/Transactions/{customerId}/{accountNumber}';

    /**
     * @return \Pkj\Sbanken\Values\TransactionV2[]|\Pkj\Sbanken\Values\Collection
     */
    public function getList (TransactionV2ListRequest $request) {
        $customArgs = [
            'query' => $request ? $request->toRequestArray() : null
        ];
        $endpoint = str_replace('{accountNumber}', $request->getAccountNumber(), self::ENDPOINT_LIST);
        return $this->client->queryEndpointList('GET', $endpoint, TransactionV2::class, $customArgs);
    }
}