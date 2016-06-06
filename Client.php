<?php

namespace demi\api;

/**
 * API client class
 */
class Client
{
    public $baseUri;
    public $timeout = 30;
    public $defaultHeaders = [];
    public $defaultQueryParams = [];

    public function __construct(Array $config = [])
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Create new API request
     *
     * @param string $url
     * @param string $method
     *
     * @return \demi\api\Request
     */
    public function apiRequest($url, $method = Request::METHOD_GET)
    {
        $request = new Request($this);
        $request->method = $method;
        $request->url = $url;

        return $request;
    }

    /**
     * Create new GET api request
     *
     * @param string $url
     *
     * @return \demi\api\Request
     */
    public function get($url)
    {
        return $this->apiRequest($url, Request::METHOD_GET);
    }

    /**
     * Create new POST api request
     *
     * @param string $url
     *
     * @return \demi\api\Request
     */
    public function post($url)
    {
        return $this->apiRequest($url, Request::METHOD_POST);
    }

    /**
     * Create new PUT api request
     *
     * @param string $url
     *
     * @return \demi\api\Request
     */
    public function put($url)
    {
        return $this->apiRequest($url, Request::METHOD_PUT);
    }

    /**
     * Create new DELETE api request
     *
     * @param string $url
     *
     * @return \demi\api\Request
     */
    public function delete($url)
    {
        return $this->apiRequest($url, Request::METHOD_DELETE);
    }
}