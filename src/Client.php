<?php
namespace Pkj\Sbanken;

use GuzzleHttp\ClientInterface;
use Pkj\Sbanken\Endpoint\Accounts;
use Pkj\Sbanken\Endpoint\Transactions;
use Pkj\Sbanken\Endpoint\Transfers;
use Pkj\Sbanken\Exceptions\SbankenItemNotFoundException;

/**
 * Class Client
 * @package Pkj\Sbanken
 */
class Client
{
    private $credentials;

    private $httpClient;

    private $accessToken;

    const IDENTITY_SERVER_URL = 'https://api.sbanken.no/identityserver/connect/token';

    public function __construct(Credentials $credentials, ClientInterface $client)
    {
        $this->credentials = $credentials;
        $this->httpClient = $client;
    }

    static public function factory(Credentials $credentials)
    {
        return new self($credentials, new \GuzzleHttp\Client());
    }

    public function Accounts ()
    {
        return new Accounts($this);
    }

    public function Transactions ()
    {
        return new Transactions($this);
    }

    public function Transfers ()
    {
        return new Transfers($this);
    }

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



    public function queryEndpointList($method, $url, $valueClass, $customArgs = [])
    {
        $data = $this->queryEndpoint($method, $url, $customArgs);
        $result = [];
        foreach ($data->items as $item) {
            $result[] =  new $valueClass((array)$item);
        }
        return $result;
    }

    public function queryEndpointItem($method, $url, $valueClass, $customArgs = [])
    {
        $data = $this->queryEndpoint($method, $url, $customArgs);
        if ($data->item === null) {
            throw new SbankenItemNotFoundException();
        }
        return new $valueClass((array)$data->item);
    }

}