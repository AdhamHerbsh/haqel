<?php

require('config.php');

// Start the session
session_start();

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve-submit'])) {
    
    // Standard Order ID
    $order_id = $_POST['oid'] ?? "";

    // Special Order ID
    $special_order_id = $_POST['soid'] ?? "";
    
    if($order_id > 0){
        $order_status = 'approved'; // Default status
        $order_stage = 'shipping'; // Default stage
        
        // Prepare the SQL query
        $stmt = $conn->prepare("UPDATE orders SET OSTATUS = ?, OSTAGE = ?, WS_ID = ?  WHERE OID = ?");
        
        // Bind parameters with appropriate types
        $stmt->bind_param("ssii", $order_status, $order_stage, $user_id, $order_id);
        
        // Execute the statement
        $stmt->execute();
        
        $page = 'home';
    }elseif ($special_order_id > 0){
        $special_order_number = $_POST['sonumber'] ?? "";
        // Contract File
        $contract_file = $_FILES['contract_file']['name']; // Assuming file upload
        $upload_dir = "../files/contracts/wholesalers/" . $special_order_number . "-";
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

        $page = 'requests';

    }else{
        $page = "dbfail"; 
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Optionally, redirect to another page
    header("Location: ../../$page.php?action=approved");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply-submit'])) {
    
    // Special Order ID
    $special_order_id = $_POST['soid'] ?? "";    
    
    $order_status = 'applied'; // Default status
    
    // Contract File
    $contract_file = $_FILES['contract_file']['name']; // Assuming file upload
    $upload_dir = "../files/contracts/retailers/" . $order_status . "-";
    $uploaded_file_path = $upload_dir . basename($contract_file);
    
    // Handle file upload
    if (!move_uploaded_file($_FILES['contract_file']['tmp_name'], $uploaded_file_path)) {
        die("File upload failed.");
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE special_orders SET SOSTATUS = ? WHERE SOID = ?");
    
    // Bind parameters with appropriate types
    $stmt->bind_param("si", $order_status, $special_order_id);
    
    // Execute the statement
    $stmt->execute();
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Optionally, redirect to another page
    header("Location: ../../my-orders.php?action=applied");

}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish-submit'])) {
    
    // Special Order ID
    $special_order_id = $_POST['soid'] ?? "";
        
    $order_status = 'finished'; // Default status
    
    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE special_orders SET SOSTATUS = ? WHERE SOID = ?");
    
    // Bind parameters with appropriate types
    $stmt->bind_param("si", $order_status, $special_order_id);
    
    // Execute the statement
    $stmt->execute();
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Optionally, redirect to another page
    header("Location: ../../my-orders.php?action=finished");

}
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // Order ID
    $order_id = $_POST['oid'] ?? "";

    // Order Stage Value
    $order_stage = $_POST['ostage'] ?? ""; 

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE orders SET OSTAGE = ? WHERE OID = ?");
    
    // Bind parameters with appropriate types
    $stmt->bind_param("si", $order_stage, $order_id);
    
    // Execute the statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    
    // Optionally, redirect to another page
    header("Location: ../../home.php");
}


?>