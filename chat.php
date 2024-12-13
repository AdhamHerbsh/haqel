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
    if ($user_id === null) {
        header("Location: 404.php"); // Redirect to 404 page if user is not logged in
        exit();
    }
    ?>

    <main>
        <!--    Chat Section Start -->
        <div class="container-fluid product">
            <div class="container py-5">
                <div class="section-title">
                    <h1>Chat With Retailer Client</h1>
                    <h3 class="text-muted">Make Deal With Retailers</h3>
                </div>
                <div class="container py-5">

                    <!--    Users Chat Section    -->
                    <div class="card-container">
                    <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Joud Abdelrahman</h4>
                                        <p class="card-title"><span class="fw-bold"><i class="bx bx-package bx-sm"></i> Order Number:</span> #<?= "236598" ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 align-content-center">
                                    <div class="text-end">
                                        <a class="btn btn-primary" href="">Chat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--    Users Chat Section  -->

                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10">
                            <!-- Chat Header -->
                            <div class="chat-info text-center p-2 border border-primary border-2 rounded-2 mb-3">
                                <p>
                                    <span class="fw-bold"><i class="bx bx-user bx-sm"></i> Retailer Name:</span> <?= " Mohamed Ahmed" ?>
                                    <span class="mx-2"></span>
                                    <span class="fw-bold"><i class="bx bx-package bx-sm"></i> Order Number:</span> #<?= "236598" ?>
                                </p>
                            </div>

                            <!-- Chat Body -->
                            <div class="chat-body border border-gray border-1 border-bottom-0 p-3 rounded-top" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                                <!-- Incoming Message -->
                                <div class="d-flex align-items-start mb-3">
                                    <div>
                                        <p class="bg-white p-3 rounded-pill shadow-sm mb-1">
                                            Hello, how are you?
                                        </p>
                                        <small class="text-muted">01:22 PM</small>
                                    </div>
                                </div>

                                <!-- Outgoing Message -->
                                <div class="d-flex justify-content-end mb-3">
                                    <div>
                                        <p class="bg-primary text-white p-3 rounded-pill shadow-sm mb-1">
                                            I'm good, thank you!
                                        </p>
                                        <small class="text-muted">01:23 PM</small>
                                    </div>
                                </div>

                                <!-- Another Incoming Message -->
                                <div class="d-flex align-items-start mb-3">
                                    <div>
                                        <p class="bg-white p-3 rounded-pill shadow-sm mb-1">
                                            Can we talk about the order?
                                        </p>
                                        <small class="text-muted">01:24 PM</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Chat Input -->
                            <div class="chat-input bg-white p-3 pt-0 border border-gray border-1 border-top-0 rounded-bottom">
                                <form class="d-flex">
                                    <div class="flex-grow-1 me-2">
                                        <input type="text" name="chat-input" id="chat-input" class="form-control rounded-pill" placeholder="Type a message..." />
                                    </div>
                                    <button type="submit" class="btn btn-primary rounded-pill">
                                        Send
                                        <i class="bx bx-paper-plane bx-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--    Chat Section End -->
    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>