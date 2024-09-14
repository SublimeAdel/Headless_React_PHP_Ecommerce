<?php

// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Allow the following HTTP methods
header("Access-Control-Allow-Methods: GET, POST, DELETE");

// Allow headers that might be sent by the client, like content type or authorization headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// JSON
header("Content-type: application/json; charset=UTF-8");

require __DIR__ . '/vendor/autoload.php';

use App\api\API;

$api = new API();

try {
    // serve the requests
    $api->proccessRequest($_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    http_response_code(500);  // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}