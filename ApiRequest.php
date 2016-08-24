<?php

namespace demi\api;

/**
 * Class ApiRequest
 *
 * Static-alias access for api-client methods
 */
class ApiRequest
{
    /**
     * Sent request
     *
     * @param string $method
     * @param string $url
     * @param array $queryParams
     * @param array $postParams
     * @param array $headerParams
     *
     * @return \demi\api\Response
     */
    protected static function sendRequest($method, $url, $queryParams = [], $postParams = [], $headerParams = [])
    {
        $client = new Client();

        return $client->$method($url)
            ->setQueryParam($queryParams)
            ->setPostParam($postParams)
            ->setHeaderParam($headerParams)
            ->send();
    }

    /**
     * Send GET-request
     *
     * @param string $url
     *
     * @param array $queryParams
     * @param array $headerParams
     *
     * @return \demi\api\Response
     */
    public static function get($url, $queryParams = [], $headerParams = [])
    {
        return static::sendRequest('get', $url, $queryParams, [], $headerParams);
    }

    /**
     * Send POST-request
     *
     * @param string $url
     *
     * @param array $queryParams
     * @param array $postParams
     * @param array $headerParams
     *
     * @return \demi\api\Response
     */
    public static function post($url, $queryParams = [], $postParams = [], $headerParams = [])
    {
        return static::sendRequest('post', $url, $queryParams, $postParams, $headerParams);
    }

    /**
     * Send PUT-request
     *
     * @param string $url
     *
     * @param array $queryParams
     * @param array $postParams
     * @param array $headerParams
     *
     * @return \demi\api\Response
     */
    public static function put($url, $queryParams = [], $postParams = [], $headerParams = [])
    {
        return static::sendRequest('put', $url, $queryParams, $postParams, $headerParams);
    }

    /**
     * Send DELETE-request
     *
     * @param string $url
     *
     * @param array $queryParams
     * @param array $postParams
     * @param array $headerParams
     *
     * @return \demi\api\Response
     */
    public static function delete($url, $queryParams = [], $postParams = [], $headerParams = [])
    {
        return static::sendRequest('delete', $url, $queryParams, $postParams, $headerParams);
    }
}