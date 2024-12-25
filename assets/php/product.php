<?php

require('config.php');

// Start the session
session_start();


$user_id = $_SESSION['user_id'];

// New Product
if (isset($_POST['create'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize and validate input data
        $pcategory = htmlspecialchars(trim($_POST['pcategory']));
        $pname = htmlspecialchars(trim($_POST['pname']));
        $pcountry = htmlspecialchars(trim($_POST['pcountry']));
        $pprice = filter_var($_POST['pprice'], FILTER_VALIDATE_FLOAT);
        $pkeywords = htmlspecialchars(trim($_POST['pkeywords']));
        $pquantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
        $pdescription = htmlspecialchars(trim($_POST['pdescription']));
        $user_id = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT); // Assuming user_id is stored in session

        // Validate required fields
        if (empty($pcategory) || empty($pname) || empty($pcountry) || $pprice === false || $pquantity === false || empty($pdescription)) {
            header("Location: ../../add-product.php?action=error&message=invalid_input");
            exit;
        }

        // Set default image path based on product category and name
        $pimage = "assets/img/" . strtolower($pcategory) . "/" . strtolower($pname) . ".png";

        // Determine product status based on quantity
        $pstatus = ($pquantity > 0) ? "available" : "unavailable";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Products 
            (PNAME, PCATEGORY, PCOUNTRY, PPRICE, PSTATUS, PKEYWORDS, PQUANTITY, PDESCRIPTION, PIMAGE, USER_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            header("Location: ../../add-product.php?action=error&message=stmt_error");
            exit;
        }

        // Bind parameters
        $stmt->bind_param(
            "sssdssissi",
            $pname,
            $pcategory,
            $pcountry,
            $pprice,
            $pstatus,
            $pkeywords,
            $pquantity,
            $pdescription,
            $pimage,
            $user_id
        );

        // Execute the query
        if ($stmt->execute()) {
            header("Location: ../../add-product.php?action=success");
        } else {
            header("Location: ../../add-product.php?action=error&message=query_failed");
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}

// Edit Product
if (isset($_POST['save']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input data
    $pid = filter_var($_POST['pid'], FILTER_VALIDATE_INT); // Validate PID as an integer
    $pcategory = htmlspecialchars(trim($_POST['pcategory']));
    $pname = htmlspecialchars(trim($_POST['pname']));
    $pcountry = htmlspecialchars(trim($_POST['pcountry']));
    $pprice = filter_var($_POST['pprice'], FILTER_VALIDATE_FLOAT); // Validate as float
    $pkeywords = htmlspecialchars(trim($_POST['pkeywords']));
    $pquantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT); // Validate as integer
    $pdescription = htmlspecialchars(trim($_POST['pdescription']));

    // Validate required fields
    if ($pid === false || empty($pcategory) || empty($pname) || empty($pcountry) || $pprice === false || $pquantity === false || empty($pdescription)) {
        header("Location: ../../add-product.php?action=error&message=invalid_input");
        exit;
    }

    // Determine product status based on quantity
    $pstatus = ($pquantity > 0) ? "available" : "unavailable";


    // Prepare the SQL query
    $stmt = $conn->prepare("UPDATE products SET PNAME = ?, PCATEGORY = ?, PCOUNTRY = ?, PPRICE = ?, PSTATUS = ?, PKEYWORDS = ?, PQUANTITY = ?, PDESCRIPTION = ? WHERE PID = ?");

    if (!$stmt) {
        header("Location: ../../add-product.php?action=error&message=stmt_error");
        exit;
    }

    // Bind parameters with appropriate types
    $stmt->bind_param(
        "sssdssisi",
        $pname,
        $pcategory,
        $pcountry,
        $pprice,
        $pstatus,
        $pkeywords,
        $pquantity,
        $pdescription,
        $pid
    );

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: ../../add-product.php?action=edited");
    } else {
        header("Location: ../../add-product.php?action=error&message=query_failed");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
