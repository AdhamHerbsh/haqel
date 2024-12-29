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
if ($user_id === null | $user_type != "admin") {
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
$users = $result->fetch_all(MYSQLI_ASSOC);

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
                    <h1>Users</h1>
                    <h3 class="text-muted">All Users List</h3>
                </div>
                <div class="table-responsive">
                    <table class="table"  id="usersTable">
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
                                <th scope="col">Full Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Type</th>
                                <th scope="col">Password</th>
                                <th scope="col">###</th>
                                <th scope="col">###</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($user['FNAME'] . " " . $user['LNAME']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($user['PHONE']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($user['USERNAME']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?= htmlspecialchars($user['USER_TYPE']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">••••••••••••</p>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="view-file.php?file=<?= urlencode($user['commercial_register_file']) ?? " no_file"; ?>">View</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="assets/php/user.php?id=<?= htmlspecialchars($user['ID']); ?>">Delete</a>
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
