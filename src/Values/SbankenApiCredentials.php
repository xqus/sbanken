<?php

namespace Pkj\Sbanken\Values;


/**
 * Class SbankenApiCredentials
 *
 * @property-read string $accessToken
 * @property-read \DateTime $expiresAt
 *
 * @package Pkj\Sbanken\Values
 */
class SbankenApiCredentials extends ValueObject
{

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var \DateTime
     */
    protected $expiresAt;


    public function hasExpired () {
        if (!$this->expiresAt) {
            return false;
        }
        $now = new \DateTime();
        return $this->expiresAt <= $now;
    }

}