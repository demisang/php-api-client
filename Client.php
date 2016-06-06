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

    /**
     * Create new API call
     *
     * @param string $url
     * @param string $method
     *
     * @return \demi\api\Call
     */
    public function apiCall($url, $method = Call::METHOD_GET)
    {
        $call = new Call($this);
        $call->method = $method;
        $call->url = $url;

        return $call;
    }

    /**
     * Create new GET api call
     *
     * @param string $url
     *
     * @return \demi\api\Call
     */
    public function get($url)
    {
        return $this->apiCall($url, Call::METHOD_GET);
    }

    /**
     * Create new POST api call
     *
     * @param string $url
     *
     * @return \demi\api\Call
     */
    public function post($url)
    {
        return $this->apiCall($url, Call::METHOD_POST);
    }

    /**
     * Create new PUT api call
     *
     * @param string $url
     *
     * @return \demi\api\Call
     */
    public function put($url)
    {
        return $this->apiCall($url, Call::METHOD_PUT);
    }

    /**
     * Create new DELETE api call
     *
     * @param string $url
     *
     * @return \demi\api\Call
     */
    public function delete($url)
    {
        return $this->apiCall($url, Call::METHOD_DELETE);
    }
}