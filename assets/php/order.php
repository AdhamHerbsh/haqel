<?php
// Include database connection
require 'config.php';

// Ensure session is started
session_start();

$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['standard-order'])) {
    // Check if cart is available in the session
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("No items in the cart to place an order.");
    }

    // Collect data from the form
    $otype = $_POST['otype'] ?? 'standard';
    $pay_method = $_POST['pay_method'] ?? '';
    $delivery_option = $_POST['delivery_option'] ?? '';
    $delivery_schedule = $_POST['delivery_schedule'] ?? '';
    $days = isset($_POST['days']) ? implode(', ', $_POST['days']) : '';
    $totalprice = (float) ($_POST['totalprice'] ?? 0.00);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Assuming user_id is stored in the session

    if (!$user_id) {
        die("User not logged in.");
    }

    // Insert into `orders` table
    $order_number = uniqid('ORD'); // Generate a unique order number
    $order_date = date('Y-m-d H:i:s'); // Current date and time
    $order_status = 'unapproved'; // Default status

    $query = "INSERT INTO orders (ONUMBER, OTYPE, ODATE, OSTATUS, OPAYMETHOD, ODELIVERY, OSCHEDULE, ODAYS, OTOTALPRICE, USER_ID)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssssdi', $order_number, $otype, $order_date, $order_status, $pay_method, $delivery_option, $delivery_schedule, $days, $totalprice, $user_id);

    if (!$stmt->execute()) {
        die("Failed to insert order: " . $stmt->error);
    }

    $order_id = $stmt->insert_id; // Get the last inserted order ID

    // Insert items into `order_items` table
    $query_item = "INSERT INTO order_items (OIPID, OIOID, OIQUANTITY, OIPRICE) VALUES (?, ?, ?, ?);";
    $stmt_item = $conn->prepare($query_item);

    foreach ($_SESSION['cart'] as $pid => $item) {
        $quantity = $item['QUANTITY'];
        $price = $item['PPRICE'];

        $stmt_item->bind_param('iiid', $pid, $order_id, $quantity, $price);

        if (!$stmt_item->execute()) {
            die("Failed to insert order item: " . $stmt_item->error);
        }
    }

    // Clear the cart session after successful insertion
    unset($_SESSION['cart']);
    unset($_SESSION['cartCount']);

    // Success message or redirect
    // Redirect to a success page
    header("Location: ../../my-orders.php?action=added&type=standard");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['special-order'])) {
    // Retrieve form data
    $otype = $_POST['otype'] ?? '';
    $pname = $_POST['pname'] ?? '';
    $pcategory = $_POST['pcategory'] ?? '';
    $pprice = $_POST['pprice'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;
    $receiveddate = $_POST['received_date'] ?? '';
    $schedule_option = $_POST['schedule_option'] ?? '';
    $description = $_POST['description'] ?? '';

    // Calculate total price
    $order_number = uniqid('SORD'); // Generate a unique order number
    $totalprice = $pprice * $quantity;
    $order_status = 'unapproved'; // Default status

    // Validate required fields
    if (empty($pname) || empty($pcategory) || empty($pprice) || empty($receiveddate) || empty($schedule_option)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit;
    }

    // Prepare SQL query
    $sql = "INSERT INTO special_orders (SONUMBER, SOTYPE, SOSTATUS, PNAME, PCATEGORY, PPRICE, SOQUANTITY, SORECEIVEDDATE, SOSCHEDULEOPTION, SODESCRIPTION, SOTOTALPRICE, SODATE, USER_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('sssssissssdi', $order_number, $otype, $order_status, $pname, $pcategory, $pprice, $quantity, $receiveddate, $schedule_option, $description, $totalprice, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Success message or redirect
            // Redirect to a success page
            header("Location: ../../my-orders.php?action=added&type=special");
        } else {
            echo "Error : " . $stmt->error . "";
        }

        $stmt->close();
    } else {
        // Database Fail message or redirect
        // Redirect to a dbfail page
        header("Location: ../../dbfail.php");
    }

    $conn->close();
}
