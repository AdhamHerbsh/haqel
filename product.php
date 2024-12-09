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
    if (isset($_GET['pid'])) {
        $pid = $_GET['pid'];
        // Prepare SQL to fetch product data
        $stmt = $conn->prepare("SELECT PNAME, PCATEGORY, PPRICE, PSTATUS, PKEYWORDS, PQUANTITY, PDESCRIPTION, PIMAGE, USER_ID FROM products WHERE PID = ?");

        $stmt->bind_param("i", $pid); // Bind user_id as an integer
        $stmt->execute();
        $stmt->store_result();

        // Check if data exists
        if ($stmt->num_rows > 0) {
            // Bind the result
            $stmt->bind_result($pname, $pcategory, $pprice, $pstatus, $pkeywords, $pquantity, $pdescription, $pimage, $user_id);
            $stmt->fetch();
        } else {
            echo "<script>alert('Product Data Didn't Found!');</script>";
            header("Location: 404.php");
            exit();
        }
    ?>
        <main>
            <!-- Product Start -->
            <section id="" class="">
                <div class="container-fluid">
                    <div class="container py-5">
                        <div class="section-title">
                            <h1>Our Organic Products</h1>
                            <h3 class="text-muted">See Products From Different Wholesalers</h3>
                        </div>
                        <input id="pid-input" type="hidden" value="<?= $pid ?>">
                        <div class="row">
                            <div class="col-12 col-md-6 rounded-2">
                                <img class="w-100" src="<?= $pimage ?>" alt="image not found">
                            </div>
                            <div class="col-12 col-md-6 position-relative">
                                <div class="mb-3">
                                    <h1><?= ucfirst($pname) ?></h1>
                                    <div class="text-white bg-primary-50 px-3 py-1 rounded position-absolute" style="top: 0%; left: 25%;"><span class="text-secondary"><?= ucfirst($pstatus) ?></span></div>
                                </div>
                                <div class="mb-3">
                                    <p class="text-primary fs-4"> <small class="text-black fs-6">SAR</small> <?= $pprice ?></p>
                                </div>
                                <?php
                                if (isset($_GET['pid'])) {
                                    $pid = $_GET['pid'];
                                    // Prepare SQL to fetch product data
                                    $stmt = $conn->prepare("SELECT FNAME, LNAME FROM users WHERE ID = ?");

                                    $stmt->bind_param("i", $user_id); // Bind user_id as an integer
                                    $stmt->execute();
                                    $stmt->store_result();

                                    // Check if data exists
                                    if ($stmt->num_rows > 0) {
                                        // Bind the result
                                        $stmt->bind_result($fname, $lname);
                                        $stmt->fetch();
                                        $provider = $fname . " " . $lname;
                                    } else {
                                        $provider = "Haqel";
                                    }

                                    // Close the statement and connection
                                    $stmt->close();
                                    $conn->close();
                                }
                                ?>
                                <div class="mb-3">
                                    <p class="fs-5"><strong>Provider Name:</strong> <?= ucfirst($provider) ?> </p>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <p><?= $pdescription ?></p>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-12 col-md-2">
                                            <div class="input-group quantity bg-white rounded-pill py-3" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border qty-btn">
                                                        <i class="bx bx-minus"></i>
                                                    </button>
                                                </div>
                                                <input id="qty-input" type="text" class="form-control form-control-sm text-center border-0" value="1">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border qty-btn">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-10">
                                            <a class="col-12 btn btn-primary py-3 rounded-pill fw-bold add-to-cart" href="assets/php/cart.php?pid=<?= $pid ?>&qty=1">Add To Cart <i class="bx bx-shopping-bag bx-sm"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div class="row">
                                        <p><strong>Category:</strong> <?= $pcategory ?></p>
                                    </div>
                                    <div class="row">
                                        <p><strong>Keywords:</strong> <?= $pkeywords ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-end">
                            <div class="card col-12 col-md-6 pt-5 text-center">
                                <i class="bx bx-bar-chart bx-lg text-primary"></i>
                                <div class="card-body">
                                    <h4 class="card-title text-primary mb-3">PREDICTIVE PRODUCT PRICE</h4>
                                    <a class="col-12 btn btn-primary rounded-pill fw-bold" href="predictive.php">See Now <i class="bx bx-right-arrow-alt bx-sm"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--    Product End   -->


        <?php } else { ?>
            <!--    Alter Warning Start  -->
            <div class="container py-5">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex flex-column align-items-center">

                        <i class="bx bx-error bx-lg"></i>
                        <p><strong>Wrong Url <i class="bx bx-link"></i> You Must Choose Product To Access This Page !</strong></p>
                        <a class="mb-3 btn btn-primary" href="home.php">Return To Home</a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <!--    Alter Warning End   -->
        <?php } ?>

        </main>



        <!--    Include Footer   -->

        <?php include('assets/inc/footer.php') ?>