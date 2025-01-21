<?php

// Get UserID from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
// Get UserType from session
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

if($user_type == 'wholesaler'){
    
    // Get the current date and time in the desired format
    $start_time = $_SESSION['session_start'];

    // Check for new messages
    $query = "SELECT COUNT(CID) AS NewMessagesCount FROM chats WHERE CDATE > ? AND CRECEIVER = ?";
    $stmt = $conn->prepare($query);
    echo $start_time;
    if ($stmt) {
        // Bind the parameter and execute the query
        $stmt->bind_param("si", $start_time, $user_id);

        if ($stmt->execute()) {
            // Bind the result variable
            $stmt->bind_result($newMessagesCount);

            // Fetch the result
            if ($stmt->fetch()) {
                // Store the count in the session
                $_SESSION['messageCount'] = $newMessagesCount;
            } else {
                echo "No new messages found.<br>";
                $_SESSION['messageCount'] = 0; // Default to 0 if no messages are found
            }
        } else {
            die("Query execution failed: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } else {
        die("Failed to prepare the statement: " . $conn->error);
    }
    
}else{

// Check Order Requests
$check_order_stmt = $conn->prepare("SELECT SOID FROM special_orders WHERE USER_ID = ? AND SOSTATUS = 'unapproved'");
if (!$check_order_stmt) {
    die("Prepare failed: " . $conn->error);
}

$check_order_stmt->bind_param("i", $user_id);
$check_order_stmt->execute();
$check_order_result = $check_order_stmt->get_result();

// Initialize the session variable if not already set
$requests = 0;

// Loop through each special order
while ($row = $check_order_result->fetch_assoc()) {
    $request_stmt = $conn->prepare("SELECT RSOID FROM requests WHERE RSOID = ?");
    if (!$request_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $request_stmt->bind_param("i", $row['SOID']);
    $request_stmt->execute();
    $request_result = $request_stmt->get_result();

    // Check if there are any requests for this special order
    if ($request_result->num_rows > 0) {
        $requests += 1;
    }

    // Close the inner statement
    $request_stmt->close();
}
// Close the outer statement
$check_order_stmt->close();
}


?>
<!-- Navbar start -->
<div class="container-fluid fixed-top shadow">
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="home.php" class="navbar-brand">
                <img class="img-fluid" src="assets/img/logo/haqel-logo-thumbnail.png" alt="image not found">
            </a>
            <button class="navbar-toggler py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <i class='bx bx-menu'></i>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="home.php" class="nav-item nav-link active">Home</a>
                    <?php if ($user_type == null) { ?>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#categories" class="nav-item nav-link">Categories</a>
                        <a href="#services" class="nav-item nav-link">Services</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    <?php } else { ?>
                        <?php if ($user_type == "wholesaler") { ?>
                            <a href="predictive.php" class="nav-item nav-link">Predictive</a>
                            <a href="add-product.php" class="nav-item nav-link">My Products</a>
                            <a href="requests.php" class="nav-item nav-link">Requests</a>

                        <?php } elseif ($user_type == "retailer") { ?>
                            <a href="predictive.php" class="nav-item nav-link">Predictive</a>
                            <a href="providers.php" class="nav-item nav-link">Providers</a>
                            <a href="my-orders.php" class="nav-item nav-link">My Orders</a>
                            <a href="special-order.php" class="nav-item nav-link">Special Order</a>

                        <?php } else { ?>
                            <a href="users-list.php" class="nav-item nav-link">Users</a>

                    <?php }
                    } ?>

                </div>
                <?php if ($user_type == null) { ?>
                    <!--    Public Navbar Start  -->
                    <div class="d-flex m-3 me-0">
                        <a href="register.php" class="btn btn-primary">
                            SignUp
                        </a>
                        <span class="m-1"></span>
                        <a href="login.php" class="btn btn-primary">
                            SignIn
                        </a>
                    </div>
                    <!--    Public Navbar End  -->
                <?php } else { ?>

                    <!--    User Navbar Start  -->
                    <div class="d-flex m-3 me-0">
                        <?php if ($user_type == "wholesaler") { ?>
                            <!--    Wholesaler Navbar Start  -->
                            <a href="chat.php" class="position-relative my-auto text-black">
                                <i class="bx bx-message-detail bx-md"></i>
                                <?php if (isset($_SESSION['messageCount'])) { ?>
                                    <span class="d-inline-block btn-warning rounded-circle text-center fw-bold" style="position: relative; width: 17px; height: 17px; right: 20px; top: 0px; font-size: 0.75rem;"><?= $_SESSION['messageCount'] ?></span>
                                <?php } ?>
                            </a>
                            <!--    Wholesaler Navbar End  -->

                        <?php } elseif ($user_type == "retailer") { ?>
                            <!--    Retailer Navbar Start  -->
                            <a href="cart.php" class="position-relative text-black">
                                <i class="bx bx-basket bx-md"></i>
                                <?php if (isset($_SESSION['cartCount'])) { ?>
                                    <span class="d-inline-block btn-primary rounded-circle text-center fw-bold" style="position: relative; width: 17px; height: 17px; right: 20px; top: 10px; font-size: 0.75rem;"><?= $_SESSION['cartCount'] ?></span>
                                <?php } ?>
                            </a>
                            <!--    Retailer Navbar End  -->
                            <?php if (isset($requests) && $requests > 0) { ?>
                            <a href="my-orders.php" class="position-relative text-black">
                                <i class="bx bx-bell bx-md"></i>
                                    <span class="d-inline-block btn-warning rounded-circle text-center fw-bold" style="position: relative; width: 17px; height: 17px; right: 20px; top: 10px; font-size: 0.75rem;"><?= isset($requests) ? $requests : '0' ?></span>
                                </a>
                                <?php } ?>
                                <!--    Retailer Navbar End  -->

                        <?php } else { ?>
                        <?php } ?>
                        <!--    Account Navbar Start  -->
                        <a href="user-profile.php" class="my-auto text-black">
                            <i class="bx bx-user-circle bx-md"></i>
                        </a>
                        <!--    Account Navbar End  -->
                        <!--    User Navbar End  -->
                    <?php } ?>
                    </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->