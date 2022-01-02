<?php
namespace Pkj\Sbanken\Endpoint;
use Pkj\Sbanken\Values\Account;

/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 22.01.2018
 * Time: 20:47
 */

class Accounts
{
    use HasClient;

    const ENDPOINT_LIST = '/api/v2/Accounts/{customerId}';
    const ENDPOINT_ITEM = '/api/v2/Accounts/{customerId}/{accountNumber}';

    /**
     * @return \Pkj\Sbanken\Values\Account[]|\Pkj\Sbanken\Values\Collection
     */
    public function getList () {
        return $this->client->queryEndpointList('GET', self::ENDPOINT_LIST, Account::class);
    }

    /**
     * @return \Pkj\Sbanken\Values\Account
     */
    public function getItem ($accountNumber) {
        $endpoint = str_replace('{accountNumber}', $accountNumber, self::ENDPOINT_ITEM);
        return $this->client->queryEndpointItem('GET', $endpoint, Account::class);
    }
}
