<?php

namespace demi\api;

/**
 * API call instance
 */
class Call
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    /**
     * API client
     *
     * @var \demi\api\Client
     */
    public $client;
    /**
     * Call method
     *
     * @var string
     */
    public $method = self::METHOD_GET;
    /**
     * API call url
     *
     * @var string
     */
    public $url;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Submit current call and return response object
     *
     * @return \demi\api\Response
     */
    public function send()
    {
        $response = new Response($this);

        return $response;
    }
}