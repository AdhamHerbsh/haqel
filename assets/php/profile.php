<?php
require("config.php");

// Start session to access user_id
session_start();

// Get user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Redirect to login if user is not authenticated
if ($user_id === null) {
    header("Location: ../../login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch user inputs
    $user_type = htmlspecialchars(trim($_POST['user_type']));
    $old_file_name = htmlspecialchars(trim($_POST['old_comm_file']));
    $fname = htmlspecialchars(trim($_POST['fname']));
    $lname = htmlspecialchars(trim($_POST['lname']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $username = htmlspecialchars(trim($_POST['username']));
    $bname = isset($_POST['bname']) ? htmlspecialchars(trim($_POST['bname'])) : null;
    $btype = isset($_POST['btype']) ? htmlspecialchars(trim($_POST['btype'])) : null;
    $cov_area = isset($_POST['cov_area']) ? htmlspecialchars(trim($_POST['cov_area'])) : null;
    $bemail = isset($_POST['bemail']) ? htmlspecialchars(trim($_POST['bemail'])) : null;
    $business_segment = isset($_POST['BUSINESS_SEGMENT']) ? htmlspecialchars(trim($_POST['BUSINESS_SEGMENT'])) : null;



    // Handle file upload for the commercial register
    $comm_file = $old_file_name; // Default to the old file if no new file is uploaded
    if (isset($_FILES['comm_file']) && $_FILES['comm_file']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = ($user_type == "retailer") ? "../files/accounts/retailers/" : "../files/accounts/wholesalers/";
        
        // Generate new file name
        $new_file_name = $bname . "-" . time() . "_" . basename($_FILES['comm_file']['name']);
        $target_file = $upload_dir . $new_file_name;

        // Delete the old file if it exists
        if (!empty($old_file_name) && file_exists($old_file_name)) {
            unlink($old_file_name);
        }

        // Move the new file to the target directory
        if (move_uploaded_file($_FILES['comm_file']['tmp_name'], $target_file)) {
            $comm_file = $target_file; // Update file path in the database
        } else {
            echo "Failed to upload the new commercial register file.";
            exit();
        }
    }

    // Update user profile data
    $update_user_stmt = $conn->prepare("
        UPDATE users 
        SET FNAME = ?, LNAME = ?, PHONE = ?, USERNAME = ? 
        WHERE ID = ?
    ");
    $update_user_stmt->bind_param("ssssi", $fname, $lname, $phone, $username, $user_id);

    if ($update_user_stmt->execute()) {
        // Check if business details exist for the user
        $check_account_stmt = $conn->prepare("SELECT ID FROM account WHERE user_id = ?");
        $check_account_stmt->bind_param("i", $user_id);
        $check_account_stmt->execute();
        $check_account_stmt->store_result();

        if ($check_account_stmt->num_rows > 0) {
            // Update account details
            $update_account_stmt = $conn->prepare("
                UPDATE account 
                `BUSINESS_NAME`, `BUSINESS_EMAIL`, `BUSINESS_TYPE`, `COVERAGE_AREAS`, `BUSINESS_SEGMENT`, `COMMERCIAL_REGISTER_FILE`, `USER_ID`
                SET BUSINESS_NAME = ?, BUSINESS_EMAIL = ?, BUSINESS_TYPE = ?, COVERAGE_AREAS = ?, BUSINESS_SEGMENT = ?, COMMERCIAL_REGISTER_FILE = ?
                WHERE user_id = ?
            ");
            $update_account_stmt->bind_param("ssssssi", $bname, $bemail, $btype, $cov_area, $business_segment, $comm_file, $user_id);
            $update_account_stmt->execute();
            $update_account_stmt->close();
        } else {
            // Insert new account details
            $insert_account_stmt = $conn->prepare("
                INSERT INTO account (business_name, BUSINESS_EMAIL, BUSINESS_TYPE, COVERAGE_AREAS, BUSINESS_SEGMENT, COMMERCIAL_REGISTER_FILE, USER_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $insert_account_stmt->bind_param("ssssssi", $bname, $bemail, $btype, $cov_area, $business_segment, $comm_file, $user_id);
            $insert_account_stmt->execute();
            $insert_account_stmt->close();
        }

        $check_account_stmt->close();
    } else {
        echo "Error updating user profile: " . $conn->error;
        exit();
    }

    $update_user_stmt->close();
    $conn->close();

    // Redirect to the profile page with a success message
    header("Location: ../../user-profile.php");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
