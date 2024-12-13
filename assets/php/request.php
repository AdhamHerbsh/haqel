<?php

require('config.php');

// Start the session
session_start();

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Special Order ID
    $special_order_id = $_POST['soid'] ?? "";
    $special_order_number = $_POST['sonumber'] ?? "";
    // Contract File
    $contract_file = $_FILES['contract_file']['name']; // Assuming file upload
    $upload_dir = "../files/contracts/wholesaler/" . $special_order_number . "-";
    $uploaded_file_path = $upload_dir . basename($contract_file);

    // Handle file upload
    if (!move_uploaded_file($_FILES['contract_file']['tmp_name'], $uploaded_file_path)) {
        die("File upload failed.");
    }

    $order_status = 'approved'; // Default status

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE special_orders SET SOSTATUS = ?, CONTRACT_FILE = ?, WS_ID = ?  WHERE SOID = ?");

    // Bind parameters with appropriate types
    $stmt->bind_param("ssii", $order_status, $uploaded_file_path, $user_id, $special_order_id);

    // Execute the statement
    $stmt->execute();
    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Optionally, redirect to another page
    header("Location: ../../requests.php?action=approved");
    

}

?>