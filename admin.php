    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

    <?php

    // Get UserID from session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Check if the user ID is valid
    if ($user_id === null | $user_type != "admin") {
        header("Location: 404.php"); // Redirect to 404 page if user is not logged in
        exit();
    }
    ?>

    <!--    User Profile Section Start     -->
    <main>
        <section id="" class="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title mb-3">
                        <h1>Admin </h1>
                        <h3 class="text-muted">Control On System By Clicks</h3>
                    </div>
                    <div class="card-container">
                        <div class="card col-12 col-md-3 border-primary text-center">
                        <div class="card-icon">
                            <div class="mb-3">
                                <i class="bx bx-group bx-xxxlg"></i>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h2 class="card-title">Users</h2>
                                </div>
                                <div>
                                    <a class="btn btn-secondary fs-6 fw-bold" href="users-list.php">Control</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </section>
    </main>
    <!--    User Profile Section End     -->


    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>