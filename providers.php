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
    if ($user_id === null | $user_type != "retailer") {
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
                        <h1>Our Providers</h1>
                        <h3 class="text-muted">See Best Of Wholesalers On Website</h3>
                    </div>
                    <div class="card-container">
                        <div class="card col-12 col-md-4 border-primary text-center">
                            <div class="card-icon">
                                <div class="mb-3">
                                    <i class="bx bx-group bx-xxxlg"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h4 class="card-title">Joud Abdelrahman</h4>
                                </div>
                                <div class="mb-3">
                                    <p class="card-title">Numbers of Products: </p>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-center">
                                        <i class="bx bxs-star text-yellow"></i>
                                        <i class="bx bxs-star text-yellow"></i>
                                        <i class="bx bxs-star text-yellow"></i>
                                        <i class="bx bxs-star text-yellow"></i>
                                        <i class="bx bxs-star"></i>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="d-flex justify-content-evenly">
                                            <a class="btn btn-accent fs-6 fw-bold" href="users-list.php">More Info</a>
                                            <a class="btn btn-primary fs-6 fw-bold" href="chat.php">Chat</a>
                                    </div>
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