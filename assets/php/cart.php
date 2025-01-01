<?php

require('config.php');

// Start the session
session_start();


$user_id = $_SESSION['user_id'];

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    
    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT PID, PNAME, PCATEGORY, PCOUNTRY, PPRICE, PSTATUS, PKEYWORDS, PQUANTITY, PDESCRIPTION, PIMAGE, USER_ID FROM products WHERE PID = ?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if ($product) {
        $availableStock = (int) $product['PQUANTITY']; // Stock available

        // Determine requested quantity
        $requestedQty = isset($_GET['qty']) && is_numeric($_GET['qty']) ? (int)$_GET['qty'] : 1;

        if ($requestedQty > $availableStock) {
            // If requested quantity exceeds stock, redirect with an error message
            header("Location: ../../home.php?action=insufficient_stock&pid=$pid&stock=$availableStock#shop");
            exit;
        }

        // Check if the product already exists in the cart
        if (isset($_SESSION['cart'][$pid])) {
    
            // Get the current quantity in the cart
            $currentQty = $_SESSION['cart'][$pid]['QUANTITY'];
        
            // Calculate new quantity
            $newCartQty = $currentQty + $requestedQty;

            if ($newCartQty > $availableStock) {
                // If combined quantity exceeds stock, redirect with an error
                header("Location: ../../home.php?action=insufficient_stock&pid=$pid&stock=$availableStock#shop");
                exit;
            }

            // Update the quantity
            $_SESSION['cart'][$pid]['QUANTITY'] = $newCartQty;
        } else {
            // Add a new product to the cart
            $ws_id = $product['USER_ID'];

            $stmt = $conn->prepare("SELECT BUSINESS_NAME FROM account WHERE USER_ID = ?");
            $stmt->bind_param("i", $ws_id);
            $stmt->execute();
            $product_user = $stmt->get_result()->fetch_assoc();

            $_SESSION['cart'][$pid] = [
                'PID' => $product['PID'],
                'PNAME' => $product['PNAME'],
                'PPRICE' => $product['PPRICE'],
                'PIMAGE' => $product['PIMAGE'],
                'PUSER_ID' => $product['USER_ID'],
                'PWHOLESALER' => $product_user['BUSINESS_NAME'],
                'QUANTITY' => $requestedQty // Requested quantity
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

    // Initialize the response array
    $response = [
        'status' => 'success',
        'message' => 'Cart updated successfully.',
        'errors' => [],
    ];

    // Update the session cart
    $_SESSION['cart'] = [];

    foreach ($cartData as $item) {
        $pid = $item['PID'];
        $quantity = $item['QUANTITY'];

        // Fetch the stock quantity for the product
        $stmt = $conn->prepare("SELECT PQUANTITY FROM products WHERE PID = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
            $availableStock = (int)$product['PQUANTITY'];

            // Validate the requested quantity against available stock
            if ($quantity > $availableStock) {
                // Add an error for this product
                $response['status'] = 'error';
                $response['errors'][] = "Product Avaliable Quantity $availableStock: Requested quantity exceeds available stock.";
                
                // Add the product to the session with the maximum available stock
                $quantity = $availableStock;
            }

            // Add the product to the session cart
            $_SESSION['cart'][$pid] = [
                'PID' => $item['PID'],
                'PNAME' => $item['PNAME'],
                'PPRICE' => $item['PPRICE'],
                'PIMAGE' => $item['PIMAGE'],
                'PUSER_ID' => $item['PUSER_ID'],
                'PWHOLESALER' => $item['PWHOLESALER'],
                'QUANTITY' => $quantity,
            ];
        } else {
            // Handle product not found
            $response['status'] = 'error';
            $response['errors'][] = "Product ID $pid not found.";
        }

        $stmt->close();
    }

    // Return the response
    echo json_encode($response);
    exit;
}



// If clearing the cart
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    unset($_SESSION['cartCount']);
    header("Location: ../../home.php?action=cleared");
    exit;
}