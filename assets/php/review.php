<?php

require('config.php');

// Start the session
session_start();

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['closed-submit'])) {
    
    // Special Order ID
    $order_id = $_POST['oid'] ?? "";
    $wholesaler_id = $_POST['wsid'] ?? "";
    $rate = $_POST['rate'] ?? "";
    $message = $_POST['message'] ?? "";
    $current_date = date("Y-m-d H:i:s");
    
    $order_status = 'closed'; // Default status
    
    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO `reviews`(`RATE`, `MESSAGE`, `RDATE`, `OID`,`WS_ID`, `USER_ID`) VALUES ( ?, ?, ?, ?, ?, ? )");
    
    // Bind parameters with appropriate types
    $stmt->bind_param("issiii", $rate, $message, $current_date, $order_id, $wholesaler_id, $user_id);
    
    // Execute the statement
    $stmt->execute();
    

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE orders SET OSTATUS = ? WHERE OID = ?");
    
    // Bind parameters with appropriate types
    $stmt->bind_param("si", $order_status, $order_id);
    
    // Execute the statement
    $stmt->execute();
    
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Optionally, redirect to another page
    header("Location: ../../my-orders.php?action=approved");
}


?>