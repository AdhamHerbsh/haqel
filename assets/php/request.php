<?php

// Include the database connection file
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

    if ($order_id > 0) {
        $order_status = 'approved'; // Default status
        $order_stage = 'shipping'; // Default stage

        // Prepare the SQL query
        $stmt = $conn->prepare("UPDATE orders SET OSTATUS = ?, OSTAGE = ?, WS_ID = ?  WHERE OID = ?");

        // Bind parameters with appropriate types
        $stmt->bind_param("ssii", $order_status, $order_stage, $user_id, $order_id);

        // Execute the statement
        $stmt->execute();

        // Optionally, redirect to another page
        header("Location: ../../home.php");

    } elseif ($special_order_id > 0) {

        $special_order_number = $_POST['sonumber']; // Generate a unique order number
        // Contract File
        $contract_file = $_FILES['contract_file']['name']; // Assuming file upload
        $upload_dir = "../files/contracts/wholesalers/" . $special_order_number . "-";
        $uploaded_file_path = $upload_dir . basename($contract_file);

        // Handle file upload
        if (!move_uploaded_file($_FILES['contract_file']['tmp_name'], $uploaded_file_path)) {
            die("File upload failed.");
        }
        
        $request_status = 'unapplied'; // Default status
        // Prepare SQL query
        $sql = "INSERT INTO requests (RSOID, RDATE, RCONTRACT_FILE, RSTATUS, WS_ID) VALUES (?, NOW(), ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param('issi', $special_order_id, $uploaded_file_path, $request_status, $user_id);
            
            // Execute the query
            if ($stmt->execute()) {
                // Success message or redirect
                // Redirect to a success page
                header("Location: ../../requests.php");
            } else {
                echo "Error : " . $stmt->error . "";
            }
        } else {
            echo "Error : " . $conn->error . "";
        }
        
        
        $stmt->close();
        $conn->close();

        // Optionally, redirect to another page
        header("Location: ../../requests.php");
    }

}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply-submit'])) {

    // Special Order ID
    $special_order_id = $_POST['soid'] ?? "";
    $special_order_number = $_POST['sonumber'] ?? "";
    $wholesaler_id = $_POST['wsid'] ?? "";

    $order_status = 'applied'; // Default status

    // Contract File
    $contract_file = $_FILES['contract_file']['name']; // Assuming file upload
    $upload_dir = "../files/contracts/retailers/";
    $filename = $order_status . "-" . $special_order_number . "-" . basename($contract_file);
    $uploaded_file_path = $upload_dir . $order_status . "-" . $special_order_number . "-" . basename($contract_file);

    // Handle file upload
    if (!move_uploaded_file($_FILES['contract_file']['tmp_name'], $uploaded_file_path)) {
        die("File upload failed.");
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE special_orders SET SOSTATUS = ?, CONTRACT_FILE = ?, WS_ID = ? WHERE SOID = ?");

    // Bind parameters with appropriate types
    $stmt->bind_param("ssii", $order_status, $filename, $wholesaler_id, $special_order_id);

    // Execute the statement
    if($stmt->execute()) {
        // Redirect to a success page
        $order_status = 'applied'; // Default status
        // Prepare the SQL query
        $stmt = $conn->prepare("UPDATE requests SET RSTATUS = ? WHERE RSOID = ? AND WS_ID = ?");
    
        // Bind parameters with appropriate types
        $stmt->bind_param("sii", $order_status, $special_order_id, $wholesaler_id);
    
        // Execute the statement
        $stmt->execute();
        header("Location: ../../my-orders.php?action=applied");
    } else {
        echo "Error : " . $stmt->error . "";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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

if(isset($_GET['soid'])) {

    $special_order_id = $_GET['soid'];

    // Prepare SQL to fetch special order data
    $stmt = $conn->prepare("DELETE FROM requests WHERE RSOID = ? And WS_ID = ?");

    $stmt->bind_param("ii", $special_order_id, $user_id); // Bind user_id as an integer
    
    // Check if data exists
    if ($stmt->execute()) {
        header("Location: ../../active-orders.php");
    } else {
        echo "<script>alert('Special Order Data Didn't Found!');</script>";
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}