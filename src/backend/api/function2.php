<?php

require ('../inc/dbcon.php');

// errors
function error422($message) {
     $data = [
           'status' => 422,
           'message' => $message,
     ];
     header("HTTP/1.1 422 Unprocessable Entity");
     echo json_encode($data);
     exit;
}

function getInventoryItems() {
     global $conn;

     $query = "SELECT * FROM tbl_inventory_items";
     $query_run = $conn->query($query);

     if ($query_run) {
           if ($query_run->num_rows > 0) {
                 $res = $query_run->fetch_all(MYSQLI_ASSOC);

                 $data = [
                         'status' => 200,
                         'message' => 'Inventory Items Fetched Successfully!',
                         'data' => $res
                 ];
                 header("HTTP/1.1 200 OK");
                 return json_encode($data);
           } else {
                 $data = [
                         'status' => 404,
                         'message' => 'No record found',
                 ];
                 header("HTTP/1.1 404 Not Found");
                 return json_encode($data);
           }
     } else {
           $data = [
                 'status' => 500,
                 'message' => 'Internal Server Error: ' . $conn->error,
           ];
           header("HTTP/1.1 500 Internal Server Error");
           return json_encode($data);
     }
}

function insertInventoryItem($item_id, $item_name, $item_image, $description, $quantity, $price, $status) {
     global $conn;

     $query = "INSERT INTO tbl_inventory_items (item_id, item_name, item_image, description, quantity, price, status) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
     $stmt = $conn->prepare($query);
     $stmt->bind_param("ssssdds", $item_id, $item_name, $item_image, $description, $quantity, $price, $status);

     if ($stmt->execute()) {
          $data = [
               'status' => 201,
               'message' => 'Inventory Item Inserted Successfully!'
          ];
          header("HTTP/1.1 201 Created");
          return json_encode($data);
     } else {
          error422("Error: {$stmt->error}");
     }
}

function updateInventoryItem($item_id, $item_name, $item_image, $description, $quantity, $price, $status) {
      global $conn;

      $query = "UPDATE tbl_inventory_items SET item_name = ?, item_image = ?, description = ?, quantity = ?, price = ?, status = ? WHERE item_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sssdsss", $item_name, $item_image, $description, $quantity, $price, $status, $item_id);

      if ($stmt->execute()) {
            $data = [
                  'status' => 200,
                  'message' => 'Inventory Item Updated Successfully!'
            ];
            header("HTTP/1.1 200 OK");
            return json_encode($data);
      } else {
            error422("Error: " . $stmt->error);
      }
}

function deleteInventoryItem($item_id) {
      global $conn;

      $query = "DELETE FROM tbl_inventory_items WHERE item_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $item_id);

      if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                  $data = [
                         'status' => 200,
                         'message' => 'Inventory Item Deleted Successfully!'
                  ];
                  header("HTTP/1.1 200 OK");
                  return json_encode($data);
            } else {
                  $data = [
                         'status' => 404,
                         'message' => 'No record found to delete',
                  ];
                  header("HTTP/1.1 404 Not Found");
                  return json_encode($data);
            }
      } else {
            error422("Error: " . $stmt->error);
      }
}

function updateInventoryQuantity($item_id, $quantity) {
      global $conn;
 
      $query = "UPDATE tbl_inventory_items SET quantity = ? WHERE item_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("is", $quantity, $item_id);
 
      if ($stmt->execute()) {
           $data = [
                'status' => 200,
                'message' => 'Inventory quantity updated successfully!'
           ];
           header("HTTP/1.1 200 OK");
           return json_encode($data);
      } else {
           error422("Error: " . $stmt->error);
      }
 }
 
 function getLatestItemId() {
      global $conn;
 
      // Extract the numeric part of item_id and order by it, convert the numeric part to an integer for proper sorting
      $query = "SELECT item_id FROM tbl_inventory_items 
                  ORDER BY CAST(SUBSTRING(item_id, 7) AS UNSIGNED) DESC 
                  LIMIT 1";
      $query_run = $conn->query($query);
 
      if ($query_run) {
           if ($query_run->num_rows > 0) {
                $res = $query_run->fetch_assoc();
                return $res['item_id']; // Return only the latest item_id
           } else {
                return null; // No record found
           }
      } else {
           return null; // Database error
      }
 }
 
?>
