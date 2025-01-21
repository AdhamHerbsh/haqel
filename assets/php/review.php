<?php

require('config.php');

// Start the session
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review-submit'])) {
    // Sanitize and validate inputs
    $order_id = filter_var($_POST['oid'] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $wholesaler_id = filter_var($_POST['wsid'] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $rate = filter_var($_POST['rate'] ?? "", FILTER_SANITIZE_NUMBER_INT);
    $message = htmlspecialchars($_POST['message'] ?? "", ENT_QUOTES, 'UTF-8');
    $current_date = date("Y-m-d H:i:s");
    $user_id = $_SESSION['user_id'] ?? null; // Assuming a session is used to track the logged-in user

    if (!$order_id || !$wholesaler_id || !$rate || !$user_id) {
        die("Invalid input. Please ensure all fields are filled out correctly.");
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert the review
        $insert_review_stmt = $conn->prepare(
            "INSERT INTO `reviews` (`RATE`, `MESSAGE`, `RDATE`, `OID`, `WS_ID`, `USER_ID`) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $insert_review_stmt->bind_param("issiii", $rate, $message, $current_date, $order_id, $wholesaler_id, $user_id);

        if (!$insert_review_stmt->execute()) {
            throw new Exception("Failed to insert review: " . $conn->error);
        }

        // Fetch all ratings for the wholesaler
        $fetch_ratings_stmt = $conn->prepare("SELECT RATE FROM reviews WHERE WS_ID = ?");
        $fetch_ratings_stmt->bind_param("i", $wholesaler_id);
        $fetch_ratings_stmt->execute();
        $result = $fetch_ratings_stmt->get_result();

        // Calculate average rating
        $total_rate = 0;
        $num_ratings = 0;

        while ($row = $result->fetch_assoc()) {
            $total_rate += $row['RATE'];
            $num_ratings++;
        }

        $avg_rate = $num_ratings > 0 ? $total_rate / $num_ratings : 0;

        // Update the wholesaler's account with the new average rating
        $update_account_stmt = $conn->prepare("UPDATE account SET RATE = ? WHERE USER_ID = ?");
        $update_account_stmt->bind_param("di", $avg_rate, $wholesaler_id);

        if (!$update_account_stmt->execute()) {
            throw new Exception("Failed to update wholesaler's average rating: " . $conn->error);
        }

        // Commit the transaction
        $conn->commit();

        // Close statements
        $insert_review_stmt->close();
        $fetch_ratings_stmt->close();
        $update_account_stmt->close();

        // Redirect to the orders page with a success message
        header("Location: ../../my-orders.php?action=reviewed");
        exit;
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();

        // Log the error and show a user-friendly message
        error_log($e->getMessage());
        die("An error occurred while processing your request. Please try again later.");
    } finally {
        // Close the connection
        $conn->close();
    }
}


?>