<?php

// Database configuration
define('DB_SERVER', 'localhost'); // Database server, usually 'localhost'
define('DB_USERNAME', 'root'); // Database username
define('DB_PASSWORD', ''); // Database password
define('DB_NAME', 'haqel'); // Database name

// Try connecting to the database
try {
    // Database connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check if the connection is successful
    if ($conn->connect_errno) {
        throw new Exception('Database connection failed: ' . $conn->connect_error);
    }
} catch (Exception $e) {
    // Log the error for debugging (optional)
    error_log($e->getMessage());

    // Redirect the user to the dbfail.php page
    header("Location: dbfail.php");
    exit;
}
