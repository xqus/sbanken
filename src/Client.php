<?php
namespace Pkj\Sbanken;

use GuzzleHttp\ClientInterface;
use Pkj\Sbanken\Endpoint\Accounts;
use Pkj\Sbanken\Endpoint\Transactions;
use Pkj\Sbanken\Endpoint\TransactionsV2;
use Pkj\Sbanken\Endpoint\Transfers;
use Pkj\Sbanken\Exceptions\SbankenItemNotFoundException;
use Pkj\Sbanken\Values\SbankenApiCredentials;
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
     * @var SbankenApiCredentials Sbanken access token
     */
    private $apiCredentials;

    /**
     * Sbanken URL. Base for all URLs. Default to Sbanken production.
     */
    private $serverUrl = 'https://publicapi.sbanken.no/apibeta';

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
     * Use to deal with transactions in API version 2.
     *
     * @return TransactionsV2
     */
    public function TransactionsV2 ()
    {
        return new TransactionsV2($this);
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
     * @return SbankenApiCredentials Sbanken Api Credentials containing the access token.
     */
    public function authorize ()
    {
        $client = $this->httpClient;
        $credentials = $this->credentials;

        $basicAuth = base64_encode("{$credentials->getClientId()}:{$credentials->getSecret()}");
        $accessToken = null;

        $res = $client->request('POST', 'https://auth.sbanken.no/identityserver/connect/token', [
            'form_params' => ['grant_type' => 'client_credentials'],
            'headers' => [
                'Authorization' => "Basic $basicAuth",
                'Accept'     => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'
            ]
        ]);

        $data = \GuzzleHttp\json_decode($res->getBody());
        $expiresAt = (new \DateTime())->modify("+{$data->expires_in} seconds");
        $this->apiCredentials = new SbankenApiCredentials([
            'accessToken' => $data->access_token,
            'expiresAt' => $expiresAt
        ]);
        return $this->apiCredentials;
    }

    /**
     * Set api credentials.
     *
     * @param SbankenApiCredentials $apiCredentials
     * @return $this
     */
    public function setApiCredentials (SbankenApiCredentials $apiCredentials)
    {
        $this->apiCredentials = $apiCredentials;
        return $this;
    }

    /**
     * Change the API server to something different than Sbanken production (https://api.sbanken.no).
     */
    public function setApiServer ($url) {
        $this->serverUrl = $url;
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
        if (!$this->apiCredentials) {
            throw new \Exception("Tried to call sbanken apis without calling authorize() or setApiCredentials. Please grant access token before calling other endpoints.");
        }

        if ($this->apiCredentials->hasExpired()) {
            throw new \Exception("Api credentials has expired. Please try again.");
        }

        $url = $this->serverUrl . $url;
        $url = str_replace(['{customerId}'], [$this->credentials->getCustomerId()], $url);

        $res = $this->httpClient->request($method, $url, array_merge([
            'headers' => [
                'Authorization' => "Bearer {$this->apiCredentials->accessToken}",
                'Accept'     => 'application/json'
            ]
        ], $customArgs ));
        $data = \GuzzleHttp\json_decode($res->getBody());
        if (isset($data->isError) && $data->isError) {
            throw new \Exception("Sbanken API returned error"
                . " (response code " . $res->getStatusCode() . " " . $res->getReasonPhrase() . ")."
                . " Please see attached JSON and headers.\n\n"
                . "JSON RESPONSE:\n"
                . json_encode($data, JSON_PRETTY_PRINT) . "\n\n"
                . "HEADERS:\n"
                . json_encode($res->getHeaders(), JSON_PRETTY_PRINT)
            );
        }
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
        print_r($result);
        //return new Collection((int)$data->availableItems, $result);
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
