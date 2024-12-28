<?php
require('config.php');

// Start the session
session_start();

// Retrieve session variables
$sender_id = $_SESSION['chatSender'] ?? null;
$receiver_id = $_SESSION['chatReceiver'] ?? null;
$soid = $_SESSION['chatSoid'] ?? null;

// Check if the request is a POST request for fetching messages
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'fetch') {
    $stmt = $conn->prepare("SELECT CMESSAGE, CDATE, CSENDER FROM chats WHERE CSOID = ? ORDER BY CID");
    $stmt->bind_param("s", $soid);
    $stmt->execute();
    $result = $stmt->get_result();
    $chats = $result->fetch_all(MYSQLI_ASSOC);

    // Loop through the chats and render the HTML for each message
    foreach ($chats as $chat) {
        if ($chat['CSENDER'] === $sender_id) {
            // Outgoing message
            echo '
            <div class="d-flex justify-content-end mb-3">
                <div>
                    <p class="bg-primary text-white p-3 rounded-pill shadow-sm mb-1">
                        ' . $chat['CMESSAGE'] . '
                    </p>
                    <small class="text-muted">' . $chat['CDATE'] . '</small>
                </div>
            </div>
            ';
        } else {
            // Incoming message
            echo '
            <div class="d-flex align-items-start mb-3">
                <div>
                    <p class="bg-white border border-primary p-3 rounded-pill shadow-sm mb-1">
                        ' . $chat['CMESSAGE'] . '
                    </p>
                    <small class="text-muted">' . $chat['CDATE'] . '</small>
                </div>
            </div>
            ';
        }
    }
    exit; // Terminate script after sending the response
}

// Check if it's a POST request for sending a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat-input'])) {
    // Sanitize input
    $message = htmlspecialchars(trim($_POST['chat-input']));
    $sender = $_POST['chat-sender'] ?? 0;
    $receiver = $_POST['chat-receiver'] ?? 0;
    $soid = $_POST['chat-soid'] ?? '';

    // Validate inputs
    if ($sender > 0 && $receiver > 0 && !empty($soid) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO chats (CSENDER, CRECEIVER, CSOID, CMESSAGE, CDATE) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiss", $sender, $receiver, $soid, $message);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Message sent successfully";
        } else {
            echo "Failed to send message";
        }
    } else {
        echo "Invalid input data";
    }
    exit; // Terminate script after sending the response
}
?>
