<?php

require('config.php');

// Start the session
session_start();


$user_id = $_SESSION['user_id'];

if (isset($_GET['pid'])) {

    $pid = $_GET['pid'];

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT PID, PNAME, PPRICE, PIMAGE FROM products WHERE PID = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();


    if ($product) {
        // Check if the product already exists in the cart
        if (isset($_SESSION['cart'][$pid])) {
            // Update the quantity based on the provided GET parameter
            if (isset($_GET['qty'])) {
                $_SESSION['cart'][$pid]['QUANTITY'] = (int)$_GET['qty'];
            } else {
                $_SESSION['cart'][$pid]['QUANTITY'] += 1; // Default increment
            }
        } else {
            // Add a new product to the cart
            $_SESSION['cart'][$pid] = [
                'PID' => $product['PID'],
                'PNAME' => $product['PNAME'],
                'PPRICE' => $product['PPRICE'],
                'PIMAGE' => $product['PIMAGE'],
                'QUANTITY' => isset($_GET['qty']) && is_numeric($_GET['qty']) ? (int)$_GET['qty'] : 1 // Default to 1
            ];
        }
        
        $_SESSION['cartCount'] = count($_SESSION['cart']);        
        
        header("Location: ../../home.php?action=added&qty=" . $_SESSION['cartCount'] . "#shop");

    } else {
        $response['message'] = 'Product not found.';
    }


    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateCart') {
    
    // Decode the cart data sent via AJAX
    $cartData = isset($_POST['cart']) ? $_POST['cart'] : [];

    // Update the session cart
    $_SESSION['cart'] = [];
    foreach ($cartData as $item) {
        $pid = $item['PID'];
        $pname = $item['PNAME'];
        $pprice = $item['PPRICE'];
        $pimage = $item['PIMAGE'];
        $quantity = $item['QUANTITY'];
        $_SESSION['cart'][$pid] = [
            'PID' => $pid,
            'PNAME' => $pname,
            'PPRICE' => $pprice,
            'PIMAGE' => $pimage,
            'QUANTITY' => $quantity
        ];
    }

    // Send a success response
    echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully.']);
    exit;
}


// If clearing the cart
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    unset($_SESSION['cartCount']);
    header("Location: ../../home.php?action=cleared");
    exit;
}