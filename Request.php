<?php

namespace demi\api;

/**
 * API call instance
 */
class Request
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
     * Curl custom options
     * @url http://php.net/manual/function.curl-setopt.php
     *
     * @var array
     */
    public $curlOptions = [];

    /**
     * Request method
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
    /**
     * Query(GET) params
     *
     * @var array
     */
    public $query = [];
    /**
     * Form (POST|PUT|DELETE) params
     *
     * @var array
     */
    public $formParams = [];
    /**
     * Request defaultHeaders
     *
     * @var array
     */
    public $headers = [];
    /**
     * Timeout connection seconds
     *
     * @var int
     */
    public $timeout;

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
        if ($this->method == static::METHOD_PUT) {
            $this->headers['X-HTTP-Method-Override'] = 'PUT';
        }

        $curl = curl_init($this->getFullUrl());
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getFullHeaders());
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout !== null ? $this->timeout : $this->client->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        switch ($this->method) {
            case static::METHOD_GET:
                break;
            case static::METHOD_POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->formParams));
                break;
            case static::METHOD_PUT:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->formParams));
                break;
            case static::METHOD_DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        // Set custom curl options
        curl_setopt_array($curl, $this->curlOptions);

        $response = new Response($curl);

        return $response;
    }

    /**
     * Get full query(GET) params
     *
     * @return array
     */
    protected function getFullQuery()
    {
        return array_merge($this->client->defaultQueryParams, $this->query);
    }

    /**
     * Get full url.
     *
     * if $this->url is relative - return $baseUri + $this->url
     * otherwise return $this->url
     *
     * @return string
     */
    protected function getFullUrl()
    {
        if (substr($this->url, 0, 1) === '/') {
            $url = $this->url;
        } else {
            $url = rtrim($this->client->baseUri, '/') . '/' . $this->url;
        }

        // Prepare full url string with query(GET) params
        return rtrim(rtrim($url, '?') . http_build_query($this->query), '?');
    }

    /**
     * Return all defaultHeaders.
     *
     * Merge default client defaultHeaders with $this->defaultHeaders
     *
     * @return array
     */
    protected function getFullHeaders()
    {
        $headers = array_merge($this->client->defaultHeaders, $this->headers);

        $buffer = [];
        foreach ($headers as $key => $value) {
            $buffer[] = "$key: $value";
        }

        return $buffer;
    }

    /**
     * Set query param(s)
     *
     * @param string|array $name Param name or Params array
     * @param string $value
     *
     * @return $this
     */
    public function setQueryParam($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->setQueryParam($k, $v);
            }
        } else {
            $this->query[$name] = $value;
        }

        return $this;
    }

    /**
     * Set form param(s)
     *
     * @param string|array $name Param name or Params array
     * @param string $value
     *
     * @return $this
     */
    public function setFormData($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->setFormData($k, $v);
            }
        } else {
            $this->formParams[$name] = $value;
        }

        return $this;
    }

    /**
     * Set header value(s)
     *
     * @param string|array $name Header name or Headers array
     * @param string $value
     *
     * @return $this
     */
    public function setHeaderData($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->setHeaderData($k, $v);
            }
        } else {
            $this->headers[$name] = $value;
        }

        return $this;
    }
}