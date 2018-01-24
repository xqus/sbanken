<?php
/**
 * Created by PhpStorm.
 * User: petterkjelkenes
 * Date: 24.01.2018
 * Time: 22:08
 */

namespace Pkj\Sbanken\Endpoint;


trait HasClient
{

    private $client;

    public function __construct(\Pkj\Sbanken\Client $client)
    {
        $this->client = $client;
    }
}