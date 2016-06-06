<?php

namespace demi\api;

/**
 * API call response
 */
class Response
{
    /**
     * Curl body content
     *
     * @var string
     */
    protected $body;
    /**
     * Response defaultHeaders
     *
     * @var array
     */
    protected $headers;
    /**
     * HTTP status code
     *
     * @var int
     */
    protected $statusCode;
    /**
     * HTTP status message
     *
     * @var string
     */
    protected $statusMessage;

    /**
     * Curl handler
     *
     * @var resource
     */
    protected $curlHandler;
    /**
     * Curl last error
     *
     * @var string
     */
    protected $curlError;

    /**
     * Response constructor.
     *
     * @param resource $curlHandler
     */
    public function __construct($curlHandler)
    {
        $this->curlHandler = $curlHandler;

        $this->send();
    }

    /**
     * Send curl request ad parse result
     */
    public function send()
    {
        $curl = $this->curlHandler;

        $response = curl_exec($curl);

        // Detect headerParams and body content
        $headerSize = curl_getinfo($this->curlHandler, CURLINFO_HEADER_SIZE);
        $this->headers = $this->parseHeaders(substr($response, 0, $headerSize));
//        var_dump($this->headerParams);
        $this->body = substr($response, $headerSize);
//        var_dump($this->body);
//        die;

        $this->statusCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->statusMessage = ''; // @todo http://php.net/manual/ru/function.curl-getinfo.php#41332

        if ($this->body === false) {
            $this->curlError = curl_error($curl);
        }

        curl_close($curl);
    }

    /**
     * Headers text
     *
     * @param string $headersLine
     *
     * @return array
     */
    protected function parseHeaders($headersLine)
    {
        if (empty($headersLine)) {
            return [];
        }

        $headers = [];
        $lines = explode(PHP_EOL, $headersLine);
        foreach ($lines as $line) {
            $parts = explode(':', $line);
            if (count($parts) !== 2) {
                continue;
            }

            $headers[$parts[0]] = ltrim($parts[1]);
        }

        return $headers;
    }

    /**
     * Return body content
     *
     * @param bool $asJson Make json_decode
     *
     * @return string|array
     */
    public function body($asJson = false)
    {
        $content = $this->body;

        if ($asJson) {
            $content = json_decode($content, true);
        }

        return $content;
    }

    /**
     * Return json decoded body content
     *
     * @return array|string
     */
    public function json()
    {
        return $this->body(true);
    }

    /**
     * Return all response defaultHeaders
     *
     * @return array
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * Get value from defaultHeaders by $key
     *
     * @param string $key
     * @param mixed|null $defaultValue
     *
     * @return mixed|null
     */
    public function headerValue($key, $defaultValue = null)
    {
        return array_key_exists($key, $this->headers) ? $this->headers[$key] : $defaultValue;
    }

    /**
     * Return response status code
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Return response status message
     *
     * @return string
     */
    public function statusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * Get curl last error
     *
     * @return string
     */
    public function curlError()
    {
        return $this->curlError;
    }
}