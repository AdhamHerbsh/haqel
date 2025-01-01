<?php
// Include database connection
require 'config.php';

// Ensure session is started
session_start();

$user_id = $_SESSION['user_id'];

// Check user id from session
if (!$user_id) {
    die("User not logged in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['standard-order'])) {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        die("No items in the cart to place an order.");
    }

    // Collect data from the form
    $otype = $_POST['otype'] ?? 'standard';
    $pay_method = $_POST['pay_method'] ?? '';
    $delivery_option = $_POST['delivery_option'] ?? '';
    $delivery_schedule = $_POST['delivery_schedule'] ?? '';
    $days = isset($_POST['days']) ? implode(', ', $_POST['days']) : '';

    // Group cart items by wholesaler ID
    $grouped_cart = [];
    foreach ($_SESSION['cart'] as $pid => $item) {
        $wholesaler_id = $item['PUSER_ID'];
        if (!isset($grouped_cart[$wholesaler_id])) {
            $grouped_cart[$wholesaler_id] = [];
        }
        $grouped_cart[$wholesaler_id][] = $item;
    }

    foreach ($grouped_cart as $wholesaler_id => $items) {
        // Calculate total price for this wholesaler's products
        $totalprice = array_reduce($items, function ($sum, $item) {
            return $sum + ($item['PPRICE'] * $item['QUANTITY']);
        }, 0);

        // Insert into `orders` table
        $order_number = uniqid('ORD');
        $order_date = date('Y-m-d H:i:s');
        $order_stage = 'shipping';

        $query = "INSERT INTO orders (ONUMBER, OTYPE, ODATE, OSTAGE, OPAYMETHOD, ODELIVERY, OSCHEDULE, ODAYS, OTOTALPRICE, USER_ID, WS_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssssdii', $order_number, $otype, $order_date, $order_stage, $pay_method, $delivery_option, $delivery_schedule, $days, $totalprice, $user_id, $wholesaler_id);
        if (!$stmt->execute()) {
            die("Failed to insert order: " . $stmt->error);
        }

        $order_id = $stmt->insert_id;

        // Insert items into `order_items` table
        $query_item = "INSERT INTO order_items (OIPID, OIOID, OIQUANTITY, OIPRICE) VALUES (?, ?, ?, ?);";
        $stmt_item = $conn->prepare($query_item);

        foreach ($items as $item) {
            $pid = $item['PID'];
            $quantity = $item['QUANTITY'];
            $price = $item['PPRICE'];

            // Insert order items
            $stmt_item->bind_param('iiid', $pid, $order_id, $quantity, $price);
            if (!$stmt_item->execute()) {
                die("Failed to insert order item: " . $stmt_item->error);
            }

            // Check and update product stock
            $query_stock = "SELECT PQUANTITY FROM products WHERE PID = ?";
            $stmt_stock = $conn->prepare($query_stock);
            $stmt_stock->bind_param('i', $pid);
            if (!$stmt_stock->execute()) {
                die("Failed to fetch product stock: " . $stmt_stock->error);
            }

            $result_stock = $stmt_stock->get_result();
            if ($result_stock->num_rows > 0) {
                $product = $result_stock->fetch_assoc();
                $current_stock = $product['PQUANTITY'];

                if ($current_stock < $quantity) {
                    die("Insufficient stock for product ID $pid.");
                }

                // Update product quantity
                $new_stock = $current_stock - $quantity;
                $new_status = $new_stock === 0 ? 'unavailable' : 'available';

                $query_update_stock = "UPDATE products SET PQUANTITY = ?, PSTATUS = ? WHERE PID = ?";
                $stmt_update_stock = $conn->prepare($query_update_stock);
                $stmt_update_stock->bind_param('isi', $new_stock, $new_status, $pid);
                if (!$stmt_update_stock->execute()) {
                    die("Failed to update product stock: " . $stmt_update_stock->error);
                }
            } else {
                die("Product ID $pid not found in the database.");
            }
        }
    }

    // Clear the cart session after successful insertion
    unset($_SESSION['cart']);
    unset($_SESSION['cartCount']);

    // Redirect to a success page
    header("Location: ../../my-orders.php?action=added&type=standard");
    exit;
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
    $days = isset($_POST['days']) ? implode(', ', $_POST['days']) : '';
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
    $sql = "INSERT INTO special_orders (SONUMBER, SOTYPE, SOSTATUS, PNAME, PCATEGORY, PPRICE, SOQUANTITY, SORECEIVEDDATE, SOSCHEDULEOPTION, SODESCRIPTION, SOTOTALPRICE, SODATE, USER_ID, SODAYS) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('sssssissssdis', $order_number, $otype, $order_status, $pname, $pcategory, $pprice, $quantity, $receiveddate, $schedule_option, $description, $totalprice, $user_id, $days);

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