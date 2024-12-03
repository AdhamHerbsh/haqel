<?php

require('config.php');

// Start the session
session_start();

// New User Register
if (isset($_POST['register_submit'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve and sanitize inputs
        $fname = htmlspecialchars(trim($_POST['fname']));
        $lname = htmlspecialchars(trim($_POST['lname']));
        $phone = htmlspecialchars(trim($_POST['phone']));
        $user_type = htmlspecialchars(trim($_POST['user_type']));
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $cpassword = htmlspecialchars(trim($_POST['cpassword']));

        // Validate required fields
        if (empty($fname) || empty($lname) || empty($phone) || empty($user_type) || empty($username) || empty($password) || empty($cpassword)) {
            die("All fields are required!");
        }

        // Validate password match
        if ($password !== $cpassword) {
            die("Passwords do not match!");
        }

        // Check if the user already exists
        $check_stmt = $conn->prepare("SELECT ID FROM users WHERE USERNAME = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            die("Username is already taken.");
        }
        $check_stmt->close();

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (USERNAME, PASSWORD, FNAME, LNAME, PHONE, USER_TYPE, CREATED_DATE) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $current_date = date("Y-m-d H:i:s");
        $stmt->bind_param("sssssss", $username, $hashed_password, $fname, $lname, $phone, $user_type, $current_date);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id; // Get the inserted user ID
            
            $_SESSION['user_id'] = $user_id; // Store user ID in session
            $_SESSION['user_type'] = $user_type; // Store user ID in session

            // Redirect based on user type
            if ($user_type === "wholesaler") {
                header("Location: ../../wholesaler-account.php");
            } elseif ($user_type === "retailer") {
                header("Location: ../../retailer-account.php");
            } else {
                header("Location: ../../404.php");
            }
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}elseif (isset($_POST['login_submit'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve and sanitize inputs
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        // Validate fields
        if (empty($username) || empty($password)) {
            die("Please fill in all fields.");
        }

        // Prepare SQL to check user credentials
        $stmt = $conn->prepare("SELECT ID, PASSWORD, USER_TYPE FROM users WHERE USERNAME = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            // Bind the result
            $stmt->bind_result($user_id, $hashed_password, $user_type);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Login successful
                $_SESSION['user_id'] = $user_id; // Store user ID in session
                $_SESSION['username'] = $username; // Store username in session
                $_SESSION['user_type'] = $user_type; // Store username in session

                $user_type == "admin" ? header("Location: ../../admin.php") : header("Location: ../../index.php"); // Redirect to dashboard or homepage
                exit();
            } else {
                die("Invalid password. Please try again.");
            }
        } else {
            die("No user found with this username.");
        }

        $stmt->close();
        $conn->close();
    }
}elseif (isset($_GET['id'])){
    $user_id = $_GET['id'];
    // Begin a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Delete user from the 'account' table
        $delete_account_stmt = $conn->prepare("DELETE FROM account WHERE user_id = ?");
        $delete_account_stmt->bind_param("i", $user_id);
        $delete_account_stmt->execute();
        $delete_account_stmt->close();

        // Delete user from the 'users' table
        $delete_user_stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
        $delete_user_stmt->bind_param("i", $user_id);
        $delete_user_stmt->execute();
        $delete_user_stmt->close();

        // Commit the transaction
        $conn->commit();

        // Redirect with success message
        header("Location: ../../users-list.php?delete=success");
        exit();
    } catch (Exception $e) {
        // Roll back the transaction if an error occurs
        $conn->rollback();
        echo "Error deleting user: " . $e->getMessage();
    }

}else{

}
