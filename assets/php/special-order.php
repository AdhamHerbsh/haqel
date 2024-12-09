<?php
// Include database connection file
require 'config.php'; // Ensure this file contains $conn for your DB connection
// Start Session To Get Data
session_start();

$user_id = $_SESSION['user_id'];


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['create'])) {
    // Retrieve form data
    $sopname = $_POST['sopname'];
    $sopcategory = $_POST['sopcategory'];
    $sopprice = $_POST['sopprice'];
    $sopquantity = $_POST['sopquantity'];
    $sorecived_date = $_POST['sorecived_date'];
    $soschedule_option = $_POST['soschedule_option'];
    $sodescription = $_POST['sodescription'];

    // Add additional fields (e.g., created_date, user_id)
    $created_date = date('Y-m-d H:i:s'); // Current timestamp
    $user_id = 1; // Replace with session or dynamic user ID

    // SQL to insert the data
    $sql = "INSERT INTO `special_orders`(`SOPNAME`, `SOPCATEGORY`, `SOPPRICE`, `SOPQUANTITY`, `SORECIVED_DATE`, `SOSCHEDULE`, `SODESCRIPTION`, `USER_ID`, `CREATED_DATE`) VALUES (? ,? ,? ,? ,? ,? ,? ,? ,?)";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssdisssss",
            $sopname,
            $sopcategory,
            $sopprice,
            $sopquantity,
            $sorecived_date,
            $soschedule_option,
            $sodescription,
            $created_date,
            $user_id
        );

        if ($stmt->execute()) {
            // Optionally redirect to another page
            header("Location: ../../my-orders.php?action=success");
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
