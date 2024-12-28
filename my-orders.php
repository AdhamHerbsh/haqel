<!-- Include Header File -->
<?php include('assets/inc/header.php'); ?>

<!-- Include Loader File -->
<?php include('assets/inc/loader.php'); ?>

<!-- Include Navbar File -->
<?php include('assets/inc/nav.php'); ?>

<?php

// Get UserID from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if the user ID is valid
if ($user_id === null | $user_type != "retailer") {
    header("Location: 404.php"); // Redirect to 404 page if user is not logged in
    exit();
}

$status_closed = 'closed';

// Prepare SQL to fetch orders data
$stmt = $conn->prepare("SELECT * FROM `orders` WHERE USER_ID = ? AND OSTATUS NOT LIKE ?");

// Bind user_id as an integer
$stmt->bind_param('is', $user_id, $status_closed);

$stmt->execute();

// Fetch data as an associative array
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Prepare SQL to fetch special orders data
$stmt = $conn->prepare("SELECT * FROM `special_orders` WHERE USER_ID = ? AND SOSTATUS NOT LIKE ? ");

// Bind user_id as an integer
$stmt->bind_param('is', $user_id, $status_closed);

$stmt->execute();

// Fetch data as an associative array
$result = $stmt->get_result();
$special_orders = $result->fetch_all(MYSQLI_ASSOC);

?>

<!-- User Profile Section Start -->
<main>
    <section id="my-orders" class="">
        <div class="container-fluid py-5">
            <div class="container">
                <div class="section-title mb-3">
                    <h1> My Orders</h1>
                    <h3 class="text-muted">Track Your Order Until Receive It</h3>
                </div>
                <div class="col-12">
                    <div class="text-end">
                        <a class="btn btn-primary" href="special-order.php">Create Special Order <i class="bx bx-plus"></i></a>
                    </div>
                </div>
                <div class="col-12 col-md-6 justify-content-center">
                    <?php if (isset($_GET['action']) && isset($_GET['type'])) { ?>
                        <!-- Created Message Start -->
                        <div class="alert alert-primary alert-dismissible fade show m-2" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <h4 class="alert-heading"><i class="bx bx-check-circle bx-sm"></i> <?= $_GET['type'] === 'standard' ? 'Standard' : 'Special' ?> Order Created Successfully</h4>
                            <strong>Contact With Provider</strong>
                            <a href="providers.php" class="alert-link"><i class="bx bx-support bx-sm"></i></a>
                        </div>
                        <!-- Created Message End -->
                    <?php } else { ?>
                        <!-- Welcome Message Start -->
                        <div class="alert border border-primary alert-dismissible fade show m-2" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <h4 class="alert-heading">Good Morning ☻</h4>
                            <p>Welcome To Your Space</p>
                            <hr />
                            <p class="mb-0">This Table For All Orders You Created</p>
                        </div>
                        <!-- Welcome Message End -->
                    <?php } ?>
                </div>
                <div class="table-responsive overflow-md-hidden mb-3">
                    <table class="table table-hover" id="ordersTable">
                        <thead>
                            <tr>
                                <div class="row text-black-50 border-bottom border-1">
                                    <div class="col-1 text-center align-content-center">
                                        <i class="bx bx-search-alt bx-md"></i>
                                    </div>
                                    <div class="col-11 form-floating">
                                        <input type="text" class="form-control border-0 text-black" name="search" id="search" placeholder="">
                                        <label for="search">Search</label>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <th scope="col">Order Number</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Order Total Price</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order Days</th>
                                <th scope="col">Status</th>
                                <th scope="col">######</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['ONUMBER']); ?></td>
                                    <td><?= htmlspecialchars($order['OTYPE']); ?></td>
                                    <td><?= htmlspecialchars($order['OTOTALPRICE']); ?></td>
                                    <td><?= htmlspecialchars($order['ODATE']); ?></td>
                                    <td><?= htmlspecialchars($order['ODAYS']); ?></td>
                                    <td><?= htmlspecialchars($order['OSTATUS']); ?></td>
                                    <td>
                                        <?php if ($order['OSTATUS'] !== 'closed') { ?>
                                            <a class="btn btn-secondary" href="order.php?oid=<?= $order['OID'] ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php foreach ($special_orders as $specialorder) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($specialorder['SONUMBER']); ?></td>
                                    <td><?= htmlspecialchars($specialorder['SOTYPE']); ?></td>
                                    <td><?= htmlspecialchars($specialorder['SOTOTALPRICE']); ?></td>
                                    <td><?= htmlspecialchars($specialorder['SORECEIVEDDATE']); ?></td>
                                    <td><?= htmlspecialchars($specialorder['SOSCHEDULEOPTION']); ?></td>
                                    <td><?= htmlspecialchars($specialorder['SOSTATUS']); ?></td>
                                    <td>
                                        <?php if ($specialorder['SOSTATUS'] !== 'closed') { ?>
                                            <a class="btn btn-secondary" href="order.php?soid=<?= $specialorder['SOID'] ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // Prepare SQL to fetch orders data
                $stmt = $conn->prepare("SELECT * FROM `orders` WHERE USER_ID = ? AND OSTATUS LIKE ?");

                // Bind user_id as an integer
                $stmt->bind_param('is', $user_id, $status_closed);

                $stmt->execute();

                // Fetch data as an associative array
                $result = $stmt->get_result();
                $old_orders = $result->fetch_all(MYSQLI_ASSOC);

                // Prepare SQL to fetch special orders data
                $stmt = $conn->prepare("SELECT * FROM `special_orders` WHERE USER_ID = ? AND SOSTATUS LIKE ? ");
                $status_closed = 'finished';
                // Bind user_id as an integer
                $stmt->bind_param('is', $user_id, $status_closed);

                $stmt->execute();

                // Fetch data as an associative array
                $result = $stmt->get_result();
                $old_special_orders = $result->fetch_all(MYSQLI_ASSOC);

                ?>


                <!--    Old Orders Title Start    -->
                <div class="mb-3">
                    <h2>Old Orders History</h2>
                </div>
                <!--    Old Orders Title End    -->
                <div class="table-responsive overflow-md-hidden">
                    <table class="table table-hover" id="ordersTable">
                        <thead>
                            <tr>
                                <div class="row text-black-50 border-bottom border-1">
                                    <div class="col-1 text-center align-content-center">
                                        <i class="bx bx-search-alt bx-md"></i>
                                    </div>
                                    <div class="col-11 form-floating">
                                        <input type="text" class="form-control border-0 text-black" name="search" id="search" placeholder="">
                                        <label for="search">Search</label>
                                    </div>
                                </div>
                            </tr>
                            <tr>
                                <th scope="col">Order Number</th>
                                <th scope="col">Order Type</th>
                                <th scope="col">Order Total Price</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order Days</th>
                                <th scope="col">Status</th>
                                <th scope="col">######</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($old_orders as $old_order) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($old_order['ONUMBER']); ?></td>
                                    <td><?= htmlspecialchars($old_order['OTYPE']); ?></td>
                                    <td><?= htmlspecialchars($old_order['OTOTALPRICE']); ?></td>
                                    <td><?= htmlspecialchars($old_order['ODATE']); ?></td>
                                    <td><?= htmlspecialchars($old_order['ODAYS']); ?></td>
                                    <td><?= htmlspecialchars($old_order['OSTATUS']); ?></td>
                                    <td>
                                        <a class="btn btn-secondary" href="order.php?oid=<?= $old_order['OID'] ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php foreach ($old_special_orders as $old_specialorder) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($old_specialorder['SONUMBER']); ?></td>
                                    <td><?= htmlspecialchars($old_specialorder['SOTYPE']); ?></td>
                                    <td><?= htmlspecialchars($old_specialorder['SOTOTALPRICE']); ?></td>
                                    <td><?= htmlspecialchars($old_specialorder['SORECEIVEDDATE']); ?></td>
                                    <td><?= htmlspecialchars($old_specialorder['SOSCHEDULEOPTION']); ?></td>
                                    <td><?= htmlspecialchars($old_specialorder['SOSTATUS']); ?></td>
                                    <td>
                                        <a class="btn btn-secondary" href="order.php?soid=<?= $old_specialorder['SOID'] ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
</main>
<!-- User Profile Section End -->
<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>