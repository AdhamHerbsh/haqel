<?php

require('config.php');

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine account type based on form data
    $user_type = isset($_POST['bemail']) ? 'retailer' : 'wholesaler';

    // Common fields
    $business_name = htmlspecialchars(trim($_POST['bname']));
    $commercial_register_file = $_FILES['comm_file']['name']; // Assuming file upload
    $upload_dir = ($user_type == "retailer") ? "../files/accounts/retailers/" . $business_name . "-" : "../files/accounts/wholesalers/" . $business_name . "-";
    $uploaded_file_path = $upload_dir . basename($commercial_register_file);

    // Handle file upload
    if (!move_uploaded_file($_FILES['comm_file']['tmp_name'], $uploaded_file_path)) {
        die("File upload failed.");
    }

    // Fields specific to each account type
    $business_email = $user_type === 'retailer' ? htmlspecialchars(trim($_POST['bemail'])) : null;
    $business_type = $user_type === 'wholesaler' ? htmlspecialchars(trim($_POST['btype'])) : null;
    $coverage_areas = $user_type === 'wholesaler' ? htmlspecialchars(trim($_POST['cov_area'])) : null;
    $business_segment = $user_type === 'retailer' ? htmlspecialchars(trim($_POST['business_segment'])) : null;

    $user_id = $_SESSION['user_id'];

    // Prepare SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO account 
            ( business_name, business_email, business_type, coverage_areas, business_segment, commercial_register_file, user_id) 
            VALUES ( ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sssssss",
        $business_name,
        $business_email,
        $business_type,
        $coverage_areas,
        $business_segment,
        $uploaded_file_path,
        $user_id
    );

    // Execute the query
    if ($stmt->execute()) {
        header("Location: ../../index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
