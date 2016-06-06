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

// Make request to baseUri + 'users'
$request = $client->post('users')
    ->setQueryParam('id', 123) // Single param
    ->setQueryParam(['name' => 'Jack', 'company' => 'Google']) // Params array
    ->setFormData('password', '12345') // Single POST param
    ->setFormData(['email' => 'example@com', 'location' => 'London']) // POST params array
    ->setHeaderData('Connection', 'Keep-Alive') // Header value
    ->setHeaderData(['Accept' => 'image/gif', 'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8']); // Headers array

// Resets
$request->query = []; // Reset query params
$request->formParams = []; // Reset form params
$request->headers = []; // Reset headers

// Submit request and get Response object
$response = $request->send();

// Response attributes
$statusCode = $response->statusCode(); // Response code: 200, 201, 204, etc...
$bodyText = $response->body(); // Content
$bodyJson = $response->json(); // Json decoded content
$headers = $response->headers(); // Headers array
$headerValue = $response->headerValue('Encoding', 'Default value'); // Some header value
```

### As static