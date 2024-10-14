<?php

require('../inc/dbcon.php');

// Function to send error response
function error422($message)
{
   $data = [
      'status' => 422,
      'message' => $message,
   ];
   header("HTTP/1.1 422 Unprocessable Entity");
   echo json_encode($data);
   exit;
}

// Function to insert a new notification preference
function insertNotificationPreference($user_id, $item_id, $notify_on_restock)
{
   global $conn;

   $query = "INSERT INTO tbl_notification_preferences (user_id, item_id, notify_on_restock, created_at) VALUES (?, ?, ?, current_timestamp())";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("sss", $user_id, $item_id, $notify_on_restock);

   if ($stmt->execute()) {
      $data = [
         'status' => 201,
         'message' => 'Notification Preference Inserted Successfully!',
         'preference_id' => $stmt->insert_id
      ];
      header("HTTP/1.1 201 Created");
      echo json_encode($data);
   } else {
      error422("Error: {$stmt->error}");
   }
}

// Function to read notification preferences
function getNotificationPreferences($user_id, $item_id)
{
   global $conn;

   $query = "SELECT * FROM tbl_notification_preferences WHERE user_id = ? AND item_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("ss", $user_id, $item_id);

   if ($stmt->execute()) {
      $result = $stmt->get_result();
      $preferences = $result->fetch_all(MYSQLI_ASSOC);

      $data = [
         'status' => 200,
         'preferences' => $preferences
      ];
      header("HTTP/1.1 200 OK");
      echo json_encode($data);
   } else {
      error422("Error: {$stmt->error}");
   }
}

// Function to update notification preference
function updateNotificationPreference($user_id, $item_id, $notify_on_restock)
{
   global $conn;

   $query = "UPDATE tbl_notification_preferences SET notify_on_restock = ? WHERE user_id = ? AND item_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("sss", $notify_on_restock, $user_id, $item_id);

   if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
         $data = [
            'status' => 200,
            'message' => 'Notification Preference Updated Successfully!'
         ];
         header("HTTP/1.1 200 OK");
         echo json_encode($data);
      } else {
         error422("No matching record found to update.");
      }
   } else {
      error422("Error: {$stmt->error}");
   }
}

// Function to delete notification preference
function deleteNotificationPreference($item_id)
{
   global $conn;

   $query = "DELETE FROM tbl_notification_preferences WHERE item_id = ?";
   $stmt = $conn->prepare($query);
   $stmt->bind_param("s", $item_id);

   if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
         $data = [
            'status' => 200,
            'message' => 'Notification Preference Deleted Successfully!'
         ];
         header("HTTP/1.1 200 OK");
         echo json_encode($data);
      } else {
         error422("No matching record found to delete.");
      }
   } else {
      error422("Error: {$stmt->error}");
   }
}

?>