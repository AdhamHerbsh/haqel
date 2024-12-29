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

                <?php if (isset($_GET['request-file']) && $_GET['request-file'] != null ) { ?>
                    <div class="section-title mb-3">
                        <h1>Request Contract File</h1>
                        <h3 class="text-muted">See Contract File Of Special Order</h3>
                    </div>
                    <!-- View File -->
                    <iframe src="assets/php/<?= $_GET['request-file'] ?>" frameborder="0" width="100%" height="800"></iframe>
                    <!-- View File -->
                    <iframe src="assets/php/<?= $_GET['contract'] ?>" frameborder="0" width="100%" height="800"></iframe>
                <?php } elseif (isset($_GET['file']) && $_GET['file'] != null ) { ?>
                    <div class="section-title mb-3">
                        <h1>View Commerical Register File</h1>
                        <h3 class="text-muted">See User Commerical Register File</h3>
                    </div>
                    <!-- View File -->
                    <iframe src="assets/php/<?= $_GET['file'] ?>" frameborder="0" width="100%" height="800"></iframe>
                <?php } elseif (isset($_GET['contract']) && $_GET['contract'] != null ) { ?>
                    <div class="section-title mb-3">
                        <h1>Contract File</h1>
                        <h3 class="text-muted">See Contract File Of Special Order with Number <?= $_GET['sonumber'] ?></h3>
                    </div>
                    <!-- View File -->
                    <iframe src="assets/php/<?= $_GET['contract'] ?>" frameborder="0" width="100%" height="800"></iframe>
                <?php } else { ?>
                    <!--    Alter Warning Start  -->
                    <div class="container py-5">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bx bxs-file-import bx-lg"></i>
                                <p><strong>File Not Foound Or Not Uploaded</strong></p>
                                <a class="mb-3 btn btn-primary" href="users-list.php">Return</a>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <!--    Alter Warning End   -->
                <?php } ?>
            </div>
        </div>
    </section>
</main>
<!-- User Profile Section End -->
<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>