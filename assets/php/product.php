<?php

require('config.php');

// Start the session
session_start();


$user_id = $_SESSION['user_id'];

// New Product
if (isset($_POST['create'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $pname = $_POST['pname'];
        $pcategory = $_POST['pcategory'];
        $pprice = $_POST['pprice'];
        $pstatus = $_POST['pstatus'];
        $pkeywords = $_POST['pkeywords'];
        $pquantity = (int)$_POST['pquantity'];
        $pdescription = $_POST['pdescription'];
        $pimage = "assets/img/" . $pcategory . "/" . $pname . ".png";


        $stmt = $conn->prepare("INSERT INTO Products (PNAME, PCATEGORY, PPRICE, PSTATUS, PKEYWORDS, PQUANTITY, PDESCRIPTION, PIMAGE, USER_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind user_id as an integer
        $stmt->bind_param("ssdssissi", $pname, $pcategory, $pprice, $pstatus, $pkeywords, $pquantity, $pdescription, $pimage, $user_id);
        $stmt->execute();

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        header("Location: ../../add-product.php?action=success");
    }
}

// Edit Product
if (isset($_POST['save'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $pid = isset($_POST['pid']) ? intval($_POST['pid']) : null; // Ensure PID is an integer
        $pname = $_POST['pname'];
        $pcategory = $_POST['pcategory'];
        $pprice = floatval($_POST['pprice']); // Convert to float for price
        $pstatus = $_POST['pstatus'];
        $pkeywords = $_POST['pkeywords'];
        $pquantity = intval($_POST['pquantity']); // Convert to integer
        $pdescription = $_POST['pdescription'];

        // Ensure PID is not null
        if ($pid !== null) {
            // Prepare the SQL query
            $stmt = $conn->prepare("UPDATE products  SET PNAME = ?, PCATEGORY = ?, PPRICE = ?, PSTATUS = ?, PKEYWORDS = ?, PQUANTITY = ?, PDESCRIPTION = ?  WHERE PID = ?");

            // Bind parameters with appropriate types
            $stmt->bind_param("ssdssisi", $pname, $pcategory, $pprice, $pstatus, $pkeywords, $pquantity, $pdescription, $pid);

            // Execute the statement
            $stmt->execute();
            // Close the statement and connection
            $stmt->close();
            $conn->close();

            // Optionally, redirect to another page
            header("Location: ../../add-product.php?action=edited");
        }
    }
}


// Delete Product
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == "delete") {
            // Delete data from database
            $stmt = $conn->prepare("DELETE FROM products WHERE PID = ?");
            $stmt->bind_param("i", $pid); // Bind user_id as an integer
            $stmt->execute();

            // Close the statement and connection
            $stmt->close();
            $conn->close();
            header("Location: ../../add-product.php?action=deleted");
        }
    }
}
