<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include('functionStockChange.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "OPTIONS") {
   // Send a 200 OK response for preflight requests
   http_response_code(200);
   exit();
}

if ($requestMethod == "DELETE") {
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (isset($inputData['item_id'])) {
        $item_id = $inputData['item_id'];
        deleteStockChangeByItemId($item_id);
    } else {
        $data = [
            'status' => 400,
            'message' => 'Item ID is required',
        ];
        header("HTTP/1.1 400 Bad Request");
        echo json_encode($data);
    }
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode($data);
}

?>