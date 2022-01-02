<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 22.01.2018
 * Time: 20:21
 */

namespace Pkj\Sbanken;


final class Credentials
{
    /**
     * From Sbanken Website.
     * @var string
     */
    private $clientId;

    /**
     * From Sbanken Website.
     * @var string
     */
    private $secret;

    /**
     * Social security number.
     * @var int
     */
    private $customerId;

    public function __construct($clientId, $secret, $customerId)
    {
        $this->clientId = $clientId;
        $this->customerId = $customerId;
        $this->secret = $secret;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return urlencode($this->clientId);
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return urlencode($this->secret);
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }



}
