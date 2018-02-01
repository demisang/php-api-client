php-api-client
===================

PHP lib for making API calls

Installation
------------
Run:
```code
composer require "demi/php-api-client" "~1.0"
```

Usage
-----
### As client
```php
<?php

$client = new \demi\api\Client([
    'baseUri' => 'https://google.com/api/',
    'timeout' => 30,
    'defaultHeaders' => [],
    'defaultQueryParams' => [],
]);

// Simple example: get index page content
$content = $client->get('http://example.com/index.php')->send()->body();

// Make request to baseUri + 'users'
$request = $client->post('users')
    ->setQueryParam('id', 123) // Single param
    ->setQueryParam(['name' => 'Jack', 'company' => 'Google']) // Params array
    ->setPostParam('password', '12345') // Single POST param
    ->setPostParam(['email' => 'example@com', 'location' => 'London']) // POST params array
    ->setHeaderParam('Connection', 'Keep-Alive') // Header value
    ->setHeaderParam(['Accept' => 'image/gif', 'Some-Custom' => 'value']); // Headers array

// Resets
$request->queryParams = []; // Reset query params
$request->formParams = []; // Reset post params
$request->headerParams = []; // Reser headers

// Submit request and get Response object
$response = $request->send();
```

### Without client instance
```php
<?php

// Static calls
$response = \demi\api\ApiRequest::get('http://example.com/index.php');
$response = \demi\api\ApiRequest::post('http://example.com/index.php');
$response = \demi\api\ApiRequest::put('http://example.com/index.php');
$response = \demi\api\ApiRequest::delete('http://example.com/index.php');
```

### Response info
```php
$statusCode = $response->statusCode(); // Response code: 200, 201, 204, etc...
$bodyText = $response->body(); // Content
$bodyJson = $response->json(); // Json decoded content
$headerParams = $response->headers(); // Headers array
$headerValue = $response->headerValue('Encoding', 'Default value'); // Some header value
```
