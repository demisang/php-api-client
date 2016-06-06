<?php

namespace demi\api;

/**
 * API call response
 */
class Response
{
    /**
     * API call instance
     *
     * @var \demi\api\Call
     */
    public $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }
}