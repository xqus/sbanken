<?php
namespace Pkj\Sbanken;

use GuzzleHttp\ClientInterface;
use Pkj\Sbanken\Endpoint\Accounts;
use Pkj\Sbanken\Endpoint\Transactions;
use Pkj\Sbanken\Endpoint\Transfers;
use Pkj\Sbanken\Exceptions\SbankenItemNotFoundException;
use Pkj\Sbanken\Values\Collection;

/**
 * Class Client
 * @package Pkj\Sbanken
 */
class Client
{
    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string Sbanken access token
     */
    private $accessToken;

    /**
     * Sbanken token endpoint.
     */
    const IDENTITY_SERVER_URL = 'https://api.sbanken.no/identityserver/connect/token';

    /**
     * Client constructor.
     * @param Credentials $credentials
     * @param ClientInterface $client
     */
    public function __construct(Credentials $credentials, ClientInterface $client)
    {
        $this->credentials = $credentials;
        $this->httpClient = $client;
    }

    /**
     * Builds Sbanken Client with the Guzzle Http Client.
     *
     * @param Credentials $credentials
     * @return Client
     */
    static public function factory(Credentials $credentials)
    {
        return new self($credentials, new \GuzzleHttp\Client());
    }

    /**
     * Use to deal with bank accounts.
     *
     * @return Accounts
     */
    public function Accounts ()
    {
        return new Accounts($this);
    }

    /**
     * Use to deal with transactions.
     *
     * @return Transactions
     */
    public function Transactions ()
    {
        return new Transactions($this);
    }

    /**
     * Use to transfer money.
     *
     * @return Transfers
     */
    public function Transfers ()
    {
        return new Transfers($this);
    }

    /**
     * Retrieves an access token based on the credentials given to the Client object.
     *
     * Note that you can also use setAccessToken, if you already have generated an access token.
     * As of now, we dont know how long an access token lives. So be careful with setAccessToken.
     *
     * @return string The access token
     */
    public function authorize ()
    {
        $client = $this->httpClient;
        $credentials = $this->credentials;

        $basicAuth = base64_encode("{$credentials->getClientId()}:{$credentials->getSecret()}");
        $accessToken = null;

        $res = $client->request('POST', self::IDENTITY_SERVER_URL, [
            'form_params' => ['grant_type' => 'client_credentials'],
            'headers' => [
                'Authorization' => "Basic $basicAuth",
                'Accept'     => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
            ]
        ]);

        $data = \GuzzleHttp\json_decode($res->getBody());
        $this->accessToken = $data->access_token;
        return $this->accessToken;
    }

    /**
     * Sets the access token manually, use if you already generated a access token and want to use the old one.
     * @param $accessToken
     */
    public function setAccessToken ($accessToken)
    {
        $this->accessToken = $accessToken;
    }


    /**
     * Utility for endpoints
     *
     * @param $method
     * @param $url
     * @param array $customArgs
     * @return mixed
     */
    public function queryEndpoint($method, $url, $customArgs = [])
    {
        $url = str_replace(['{customerId}'], [$this->credentials->getCustomerId()], $url);

        $res = $this->httpClient->request($method, $url, array_merge([
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Accept'     => 'application/json'
            ]
        ], $customArgs ));
        $data = \GuzzleHttp\json_decode($res->getBody());
        return $data;
    }


    /**
     * Utility for endpoints
     *
     * @param $method
     * @param $url
     * @param $valueClass
     * @param array $customArgs
     * @return Collection
     */
    public function queryEndpointList($method, $url, $valueClass, $customArgs = [])
    {
        $data = $this->queryEndpoint($method, $url, $customArgs);
        $result = [];
        foreach ($data->items as $item) {
            $result[] =  new $valueClass((array)$item);
        }
        return new Collection((int)$data->availableItems, $result);
    }

    /**
     * Utility for endpoints
     *
     * @param $method
     * @param $url
     * @param $valueClass
     * @param array $customArgs
     * @return mixed
     * @throws SbankenItemNotFoundException
     */
    public function queryEndpointItem($method, $url, $valueClass, $customArgs = [])
    {
        $data = $this->queryEndpoint($method, $url, $customArgs);
        if ($data->item === null) {
            throw new SbankenItemNotFoundException();
        }
        return new $valueClass((array)$data->item);
    }

}