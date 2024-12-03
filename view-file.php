<!-- Include Header File -->
<?php include('assets/inc/header.php'); ?>

<!-- Include Loader File -->
<?php include('assets/inc/loader.php'); ?>

<!-- Include Navbar File -->
<?php include('assets/inc/nav.php'); ?>

<?php
// Start session
session_start();

// Get UserID from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if the user ID is valid
if ($user_id === null) {
    header("Location: 404.php"); // Redirect to 404 page if user is not logged in
    exit();
}

?>

<!-- User Profile Section Start -->
<main>
    <section id="" class="">
        <div class="container-fluid py-5">
            <div class="container">
                <div class="section-title mb-3">
                    <h1>View Commerical Register File</h1>
                    <h3 class="text-muted">See User Commerical Register File</h3>
                </div>
                <iframe src="assets/php/<?= $_GET['file'] ?>" frameborder="0" width="100%" height="800"></iframe>

            </div>
        </div>
    </section>
</main>
<!-- User Profile Section End -->
<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>
