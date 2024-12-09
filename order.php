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

<main>
    <section id="" class="">
    <!--    Order Details Section Start     -->
    <!--    Review and Feedback Section Start     -->
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title mb-3">
                        <h1>Review and Feedback</h1>
                        <h3 class="text-muted">Write Your Opinion On Wholesaler</h3>
                    </div>
                    <!--    Special Order Requests Section    -->
                    <div class="card-container">
                        <div class="card col-12 border border-1 border-white-50 mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Joud Abdelrahman</h4>
                                        <p class="card-title">Numbers of Products: </p>
                                        <div class="d-flex">
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 align-content-center">
                                    <div class="d-flex justify-content-around align-items-end">
                                        <a class="btn btn-primary" href="">Download Contract</a>
                                        <a class="btn btn-danger" href="">Reject</a>
                                        <form class="d-flex">
                                            <input type="file" class="form-control" name="comm_file" id="comm_file" placeholder="No File Chosen" />
                                            <span class="mx-2"></span>
                                            <button class="btn btn-primary" type="submit">Apply</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card col-12 border border-1 border-white-50 mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Joud Abdelrahman</h4>
                                        <p class="card-title">Numbers of Products: </p>
                                        <div class="d-flex">
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star text-yellow"></i>
                                            <i class="bx bxs-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 align-content-center">
                                    <div class="d-flex justify-content-around align-items-end">
                                        <a class="btn btn-primary" href="">Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--    Special Order Requests Section  -->
                    <!--    Track Order Section  -->
                    <div class="row text-center justify-content-evenly align-items-center">
                        <div class="col-12 col-md-3 position-relative p-5">
                            <div class="border border-1 border-primary rounded-circle p-4 mb-3">
                                <img class="img-fluid w-100" src="assets/img/icons/icons8-product-96.png" alt="image not found" />
                            </div>
                            <div class="mb-3">
                                <h4>status</h4>
                            </div>
                            <div class="text-white bg-primary-50 px-3 py-1 rounded position-absolute" style="bottom: 0%; left: 50%; transform: translate(-50%, 50%);"><span class="text-secondary"><?= "Done" ?></span></div>
                        </div>
                        <div class="col-1">
                            <i class="bx bx-right-arrow-alt bx-md"></i>
                        </div>
                        <div class="col-12 col-md-3 position-relative p-5">
                            <div class="border border-1 border-primary rounded-circle p-4 mb-3">
                                <img class="img-fluid w-100" src="assets/img/icons/icons8-truck-96.png" alt="image not found" />
                            </div>
                            <div class="mb-3">
                                <h4>status</h4>
                            </div>
                            <div class="text-white bg-primary-50 px-3 py-1 rounded position-absolute" style="bottom: 0%; left: 50%; transform: translate(-50%, 50%);"><span class="text-secondary"><?= "Done" ?></span></div>

                        </div>
                        <div class="col-1">
                            <i class="bx bx-right-arrow-alt bx-md"></i>
                        </div>
                        <div class="col-12 col-md-3 position-relative p-5">
                            <div class="border border-1 border-primary rounded-circle p-4 mb-3">
                                <img class="img-fluid w-100" src="assets/img/icons/icons8-contactless-delivery-96.png" alt="image not found" />
                            </div>
                            <div class="mb-3">
                                <h4>status</h4>
                            </div>
                            <div class="text-white bg-gray px-3 py-1 rounded position-absolute" style="bottom: 0%; left: 50%; transform: translate(-50%, 50%);"><span class="text-secondary"><?= "Waiting" ?></span></div>

                        </div>
                    </div>
                    <!--    Track Order Section  -->

                </div>
            </div>
            <!--    Order Details Section End     -->
                            <!--    Review and Feedback Section Start     -->
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title mb-3">
                        <h1>Review and Feedback</h1>
                        <h3 class="text-muted">Write Your Opinion On Wholesaler</h3>
                    </div>
                    <div class="container">
                        <div class="my-3">
                            <h5>Enter Order Details</h5>
                        </div>
                        <form action="" method="POST">
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">RATE:</label>
                                <input class="form-range" min="0" max="5" type="range" name="" id="" placeholder="" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">MESSAGE:</label>
                                <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--    Review and Feedback Section Start     -->

        </section>
    </main>


    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>