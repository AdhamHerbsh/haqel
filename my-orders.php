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
if ($user_id === null || $user_type != "retailer") {
    header("Location: 404.php");
    exit();
}

$status_finished = 'finished';
$stage = 'received';

// Fetch active orders
$stmt = $conn->prepare("SELECT * FROM `orders` WHERE USER_ID = ? AND OSTAGE NOT LIKE ?");
$stmt->bind_param('is', $user_id, $stage);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch active special orders
$stmt = $conn->prepare("SELECT * FROM `special_orders` WHERE USER_ID = ? AND SOSTATUS NOT LIKE ?");
$stmt->bind_param('is', $user_id, $status_finished);
$stmt->execute();
$special_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch completed orders
$stmt = $conn->prepare("SELECT * FROM `orders` WHERE USER_ID = ? AND OSTAGE LIKE ?");
$stmt->bind_param('is', $user_id, $stage);
$stmt->execute();
$old_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch completed special orders
$stmt = $conn->prepare("SELECT * FROM `special_orders` WHERE USER_ID = ? AND SOSTATUS LIKE ?");
$stmt->bind_param('is', $user_id, $status_finished);
$stmt->execute();
$old_special_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!-- Main Content -->
<main>
    <section id="my-orders" class="py-5">
        <div class="container">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <h1 class="display-4 fw-bold mb-2">My Orders</h1>
                    <p class="text-muted lead">Track your orders from creation to delivery</p>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-center justify-content-md-end">
                    <a class="btn btn-primary btn-lg" href="special-order.php">
                        <i class="bx bx-plus me-2"></i>Create Special Order
                    </a>
                </div>
            </div>

            <!-- Alerts Section -->
            <div class="row mb-4">
                <div class="col-12 col-lg-8">
                    <?php if (isset($_GET['action']) && isset($_GET['type'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-check-circle bx-md me-2"></i>
                                <div>
                                    <h4 class="alert-heading mb-1"><?= $_GET['type'] === 'standard' ? 'Standard' : 'Special' ?> Order Created Successfully</h4>
                                    <p class="mb-0">
                                        Need assistance? <a href="providers.php" class="alert-link">Contact provider <i class="bx bx-support"></i></a>
                                    </p>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info border-start border-info border-4 shadow-sm" role="alert">
                            <h4 class="alert-heading mb-1">Welcome Back! 👋</h4>
                            <p class="mb-0">View and manage all your orders in one place</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Active Orders Table -->
            <div class="shadow-sm mb-5">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Active Orders</h5>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" 
                                       id="searchActive" placeholder="Search orders...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="ordersActiveTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Order Number</th>
                                    <th>Type</th>
                                    <th>Total Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($order['ONUMBER']); ?></td>
                                        <td><span class="badge bg-primary"><?= htmlspecialchars($order['OTYPE']); ?></span></td>
                                        <td class="fw-bold text-success">$<?= number_format(htmlspecialchars($order['OTOTALPRICE']), 2); ?></td>
                                        <td><?= date('M d, Y', strtotime($order['ODATE'])); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><span class="badge bg-info"><?= htmlspecialchars($order['OSTAGE']); ?></span></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" href="order.php?oid=<?= $order['OID'] ?>">
                                                View Details <i class="bx bx-right-arrow-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($special_orders as $specialorder) : ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($specialorder['SONUMBER']); ?></td>
                                        <td><span class="badge bg-warning"><?= htmlspecialchars($specialorder['SOTYPE']); ?></span></td>
                                        <td class="fw-bold text-success">$<?= number_format(htmlspecialchars($specialorder['SOTOTALPRICE']), 2); ?></td>
                                        <td><?= date('M d, Y', strtotime($specialorder['SOSTARTDATE'])); ?></td>
                                        <td><?= date('M d, Y', strtotime($specialorder['SOENDDATE'])); ?></td>
                                        <td><?= htmlspecialchars($specialorder['SOSCHEDULEOPTION']); ?></td>
                                        <td><span class="badge bg-info"><?= htmlspecialchars($specialorder['SOSTATUS']); ?></span></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" href="order.php?soid=<?= $specialorder['SOID'] ?>">
                                                View Details <i class="bx bx-right-arrow-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Order History</h5>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" 
                                       id="search" placeholder="Search order history...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="ordersTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Order Number</th>
                                    <th>Type</th>
                                    <th>Total Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($old_orders as $old_order) : ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($old_order['ONUMBER']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($old_order['OTYPE']); ?></span></td>
                                        <td class="fw-bold">$<?= number_format(htmlspecialchars($old_order['OTOTALPRICE']), 2); ?></td>
                                        <td><?= date('M d, Y', strtotime($old_order['ODATE'])); ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><span class="badge bg-success"><?= htmlspecialchars($old_order['OSTAGE']); ?></span></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary" href="order.php?oid=<?= $old_order['OID'] ?>">
                                                View Details <i class="bx bx-right-arrow-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($old_special_orders as $old_specialorder) : ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($old_specialorder['SONUMBER']); ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($old_specialorder['SOTYPE']); ?></span></td>
                                        <td class="fw-bold">$<?= number_format(htmlspecialchars($old_specialorder['SOTOTALPRICE']), 2); ?></td>
                                        <td><?= date('M d, Y', strtotime($old_specialorder['SOSTARTDATE'])); ?></td>
                                        <td><?= date('M d, Y', strtotime($old_specialorder['SOENDDATE'])); ?></td>
                                        <td><?= htmlspecialchars($old_specialorder['SOSCHEDULEOPTION']); ?></td>
                                        <td><span class="badge bg-success"><?= htmlspecialchars($old_specialorder['SOSTATUS']); ?></span></td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary" href="order.php?soid=<?= $old_specialorder['SOID'] ?>">
                                                View Details <i class="bx bx-right-arrow-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
$stmt->close();
$conn->close();
?>

<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>