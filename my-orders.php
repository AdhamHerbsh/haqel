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

// Prepare SQL to fetch user and account data
$stmt = $conn->prepare("
    SELECT 
        u.ID,
        u.USERNAME, 
        u.FNAME, 
        u.LNAME, 
        u.PHONE, 
        u.USER_TYPE, 
        a.business_name, 
        a.business_email, 
        a.business_type, 
        a.coverage_areas, 
        a.business_segment, 
        a.commercial_register_file
    FROM 
        users u
    LEFT JOIN 
        account a 
    ON 
        u.ID = a.user_id

");

// Bind user_id as an integer
$stmt->execute();

// Fetch data as an associative array
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!-- User Profile Section Start -->
<main>
    <section id="" class="">
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
                    <?php if (isset($_GET['action'])) { ?>
                        <!--    Created Message Start    -->
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <i class="bx bx-check-circle bx-sm"></i>
                            <strong>Special Order Created Successfully</strong>
                            <a href="providers.php" class="alert-link"><i class="bx bx-support bx-sm"></i></a>
                        </div>
                        <!--    Created Message End    -->
                    <?php } ?>

                </div>
                <div class="table-responsive">
                    <table class="table" id="ordersTable">
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
                                <th scope="col">Product Name</th>
                                <th scope="col">Product Category</th>
                                <th scope="col">Order Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">###</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($order['FNAME'] . " " . $order['LNAME']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">Standard</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($order['PHONE']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($order['USERNAME']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($order['USER_TYPE']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">••••••••••••</p>
                                    </td>
                                    <td>
                                        <a class="btn btn-secondary" href="view-file.php?file=<?= urlencode($order['commercial_register_file']); ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- User Profile Section End -->
<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>