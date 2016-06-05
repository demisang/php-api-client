<?php

namespace demi\api;

/**
 * API client class
 */
class Client
{
    public $baseUri;
    public $timeout = 30;
    public $headers = [];

    public function __construct(Array $config = [])
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}