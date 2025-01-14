<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

require('function2.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "OPTIONS") {
   http_response_code(200);
   exit();
}

if ($requestMethod == "GET") {
   $latestItemId = getLatestItemId(); // Get the plain item_id

   if ($latestItemId !== null) {
      $data = [
         'status' => 200,
         'latest_item_id' => $latestItemId, // Return the latest item_id directly
      ];
      header("HTTP/1.1 200 OK");
      echo json_encode($data);
   } else {
      $data = [
         'status' => 404,
         'message' => 'No items found',
      ];
      header("HTTP/1.1 404 Not Found");
      echo json_encode($data);
   }
}
?>