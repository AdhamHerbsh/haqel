<?php

require('config.php');

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine account type based on form data
    $user_type = isset($_POST['bemail']) ? 'retailer' : 'wholesaler';


    // Fields specific to each account type
    $business_name = htmlspecialchars(trim($_POST['bname']));
    $business_email = $user_type === 'retailer' ? htmlspecialchars(trim($_POST['bemail'])) : null;
    $business_type = $user_type === 'wholesaler' ? htmlspecialchars(trim($_POST['btype'])) : null;
    $business_segment = $user_type === 'retailer' ? htmlspecialchars(trim($_POST['business_segment'])) : null;

    if ($business_type === 'provider') {
        // Common fields
        $commercial_register_file = $_FILES['comm_file']['name']; // Assuming file upload
        $upload_dir = ($user_type == "retailer") ? "../files/accounts/retailers/" . $business_name . "-" : "../files/accounts/wholesalers/" . $business_name . "-";
        $uploaded_file_path = $upload_dir . basename($commercial_register_file);
        // Handle file upload
        if (!move_uploaded_file($_FILES['comm_file']['tmp_name'], $uploaded_file_path)) {
            die("File upload failed.");
        }
    }else{
        $commercial_register_file = null;
    }


    $user_id = $_SESSION['user_id'];

    // Prepare SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO account 
            (BUSINESS_NAME, BUSINESS_EMAIL, BUSINESS_TYPE, BUSINESS_SEGMENT, COMMERCIAL_REGISTER_FILE, USER_ID) 
            VALUES ( ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "ssssss",
        $business_name,
        $business_email,
        $business_type,
        $business_segment,
        $uploaded_file_path,
        $user_id
    );

    // Execute the query
    if ($stmt->execute()) {
        header("Location: ../../home.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
