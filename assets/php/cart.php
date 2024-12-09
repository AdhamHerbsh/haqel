<?php

require('config.php');

// Start the session
session_start();


$user_id = $_SESSION['user_id'];

if (isset($_GET['pid'])) {

    $pid = $_GET['pid'];

    $token = session_id();


    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT PID, PNAME, PPRICE, PIMAGE FROM products WHERE PID = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        // Add or update the product in the session cart
        if (isset($_SESSION['cart'][$pid]) & isset($_GET['qty'])) {
            $quantity = $_GET['qty'];
            $_SESSION['cart'][$pid]['QUANTITY'] = $quantity;
        } elseif (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['QUANTITY'] += 1;
        } else {
            $_SESSION['cart'][$pid] = [
                'PID' => $product['PID'],
                'PNAME' => $product['PNAME'],
                'PPRICE' => $product['PPRICE'],
                'PIMAGE' => $product['PIMAGE'],
                'QUANTITY' => 1
            ];
        }
        $response['message'] = 'Product added to the cart.';
        $response['cartCount'] = count($_SESSION['cart']);
    } else {
        $response['message'] = 'Product not found.';
    }
    $stmt->close();
}

header("Location: ../../home.php?action=added#shop");
