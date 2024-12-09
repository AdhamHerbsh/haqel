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
        header("Location: index.php"); // Redirect to 404 page if user is not logged in
        exit();
    }
    ?>

    <!-- Hero Start -->
    <div id="hero" class="container-fluid py-5 hero-header hero-home">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-12">
                    <h1 class="p-2 mb-4 border-start border-4 border-primary display-1 text-white">Features
                    </h1>
                    <br>
                    <h2 class="text-white">We Offer Predictive Pricing and Special Orders</h2>
                    <a class="col-12 col-md-3 btn btn-primary py-2 px-3 fw-bold text-white fs-4" href="predictive.php">
                        Know More
                        <i class="bx bx-right-arrow-alt bx-sm"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Retailer Home Start -->
    <?php if ($user_type == "retailer") { ?>
        <!-- Products Start -->
        <main>
            <section id="shop" class="shop">
                <div class="container-fluid">
                    <div class="container py-5">
                        <div class="section-title">
                            <h1>Our Organic Products</h1>
                            <h3 class="text-muted">See Products From Different Wholesalers</h3>
                        </div>
                        <!-- Fruits and Vegetables Shop Start-->
                        <div class="container-fluid product py-5">
                            <div class="container py-5">
                                <div class="tab-class">
                                    <?php if (isset($_GET['action'])) { ?>
                                        <!--    Added Message Start    -->
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            <i class="bx bx-check-circle bx-sm"></i>
                                            <strong>Product Added Successfully To Cart</strong>
                                            <a href="cart.php" class="alert-link"><i class="bx bx-cart bx-sm"></i></a>
                                        </div>
                                        <!--    Added Message End    -->
                                    <?php } ?>
                                    <div class="row g-4">
                                        <!-- Search bar -->
                                        <div class="col-12 col-md-6 position-relative mx-auto">
                                            <input class="form-control border-2 border-gray py-3 rounded-pill" type="text" placeholder="Write what you want?">
                                            <button type="submit" class="btn btn-secondary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0%;">Submit Now</button>
                                        </div>
                                        <!-- Tabs -->
                                        <div class="col-12 col-md-6 text-end">
                                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                                <li class="nav-item">
                                                    <a class="d-flex p-2 m-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-all">
                                                        <span class="text-dark">All Products</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="d-flex p-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-fruits">
                                                        <span class="text-dark">Fruits</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="d-flex p-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-vegetables">
                                                        <span class="text-dark">Vegetables</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
                                        <?php
                                        // Prepare SQL to fetch user and account data
                                        $stmt = $conn->prepare("SELECT * FROM products");

                                        // Bind user_id as an integer
                                        $stmt->execute();

                                        // Fetch data as an associative array
                                        $result = $stmt->get_result();
                                        $all_products = $result->fetch_all(MYSQLI_ASSOC);
                                        ?>
                                        <div id="tab-all" class="tab-pane fade show p-0 active">
                                            <div class="row g-4">
                                                <?php if ($result->num_rows > 0) { ?>
                                                    <?php foreach ($all_products as $product) : ?>
                                                        <div class="col-12 col-md-4 p-4">
                                                            <a href="product.php?pid=<?= $product['PID'] ?>">
                                                                <div class="border border-gray rounded-2 position-relative product-item">
                                                                    <div class="product-img">
                                                                        <img src="<?= $product['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="<?= ucfirst($product['PNAME']) ?>">
                                                                    </div>
                                                                    <div class="p-4">
                                                                        <p><?= ucfirst($product['PNAME']) ?></p>
                                                                        <div class="d-md-flex justify-content-between flex-lg-wrap">
                                                                            <p class="text-dark fs-5 fw-bold mb-0"><small>SAR</small> <?= $product['PPRICE'] ?></p>
                                                                            <div class="d-md-flex justify-content-space">
                                                                                <a href="predictive.php?pid=<?= $product['PID'] ?>" class="btn border border-secondary rounded-pill text-primary"><i class="bx bx-line-chart bx-sm"></i></a>
                                                                                <div class="m-1"></div>
                                                                                <a class="btn border border-secondary rounded-pill px-3 text-primary" href="assets/php/cart.php?pid=<?= $product['PID'] ?>"><i class="bx bx-cart-download bx-sm me-2"></i> Add to cart</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php } else { ?>
                                                    <!--    Alter Warning Start  -->
                                                    <div class="container py-5">
                                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="bx bx-data bx-lg"></i>
                                                                <p><strong>No Data Found Enter At Late Time</strong></p>
                                                                <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <!--    Alter Warning End   -->
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php
                                        // Prepare SQL to fetch user and account data
                                        $stmt = $conn->prepare("SELECT * FROM products WHERE PCATEGORY = 'fruits'");

                                        // Bind user_id as an integer
                                        $stmt->execute();

                                        // Fetch data as an associative array
                                        $result = $stmt->get_result();
                                        $fruits = $result->fetch_all(MYSQLI_ASSOC);
                                        ?>
                                        <div id="tab-fruits" class="tab-pane fade show p-0">
                                            <div class="row g-4">
                                                <?php if ($result->num_rows > 0) { ?>
                                                    <?php foreach ($fruits as $fruit) : ?>
                                                        <div class="col-12 col-md-4 p-4">
                                                            <a href="product.php?pid=<?= $fruit['PID'] ?>">
                                                                <div class="border border-gray rounded-2 position-relative product-item">
                                                                    <div class="product-img">
                                                                        <img src="<?= $fruit['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="<?= ucfirst($fruit['PNAME']) ?>">
                                                                    </div>
                                                                    <div class="p-4">
                                                                        <p><?= ucfirst($fruit['PNAME']) ?></p>
                                                                        <div class="d-md-flex justify-content-between flex-lg-wrap">
                                                                            <p class="text-dark fs-5 fw-bold mb-0"><small>SAR</small> <?= $fruit['PPRICE'] ?></p>
                                                                            <div class="d-md-flex justify-content-space">
                                                                                <a href="predictive.php?pid=<?= $fruit['PID'] ?>" class="btn border border-secondary rounded-pill text-primary"><i class="bx bx-line-chart bx-sm"></i></a>
                                                                                <div class="m-1"></div>
                                                                                <button class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"><i class="bx bx-cart-download bx-sm me-2"></i> Add to cart</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php } else { ?>
                                                    <!--    Alter Warning Start  -->
                                                    <div class="container py-5">
                                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="bx bx-data bx-lg"></i>
                                                                <p><strong>No Data Found Enter At Late Time</strong></p>
                                                                <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <!--    Alter Warning End   -->

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php
                                        // Prepare SQL to fetch user and account data
                                        $stmt = $conn->prepare("SELECT * FROM products WHERE PCATEGORY = 'vegetables'");

                                        // Bind user_id as an integer
                                        $stmt->execute();

                                        // Fetch data as an associative array
                                        $result = $stmt->get_result();
                                        $vegetables = $result->fetch_all(MYSQLI_ASSOC);
                                        ?>
                                        <div id="tab-vegetables" class="tab-pane fade show p-0">
                                            <div class="row g-4">
                                                <?php if ($result->num_rows > 0) { ?>
                                                    <?php foreach ($vegetables as $vegetable) : ?>
                                                        <div class="col-12 col-md-4 p-4">
                                                            <a href="product.php?pid=<?= $vegetable['PID'] ?>">
                                                                <div class="border border-gray rounded-2 position-relative product-item">
                                                                    <div class="product-img">
                                                                        <img src="<?= $vegetable['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="<?= ucfirst($vegetable['PNAME']) ?>">
                                                                    </div>
                                                                    <div class="p-4">
                                                                        <p><?= ucfirst($vegetable['PNAME']) ?></p>
                                                                        <div class="d-md-flex justify-content-between flex-lg-wrap">
                                                                            <p class="text-dark fs-5 fw-bold mb-0"><small>SAR</small> <?= $vegetable['PPRICE'] ?></p>
                                                                            <div class="d-md-flex justify-content-space">
                                                                                <a href="predictive.php?pid=<?= $vegetable['PID'] ?>" class="btn border border-secondary rounded-pill text-primary"><i class="bx bx-line-chart bx-sm"></i></a>
                                                                                <div class="m-1"></div>
                                                                                <button class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"><i class="bx bx-cart-download bx-sm me-2"></i> Add to cart</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php } else { ?>
                                                    <!--    Alter Warning Start  -->
                                                    <div class="container py-5">
                                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="bx bx-data bx-lg"></i>
                                                                <p><strong>No Data Found Enter At Late Time</strong></p>
                                                                <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                    <!--    Alter Warning End   -->

                                                <?php } ?>
                                            </div>
                                            <?php
                                            // Close the statement and connection
                                            $stmt->close();
                                            $conn->close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fruits and Vegetables Shop End-->
                </div>
                </div>
            </section>
            <!-- Products End -->
            <!-- Special Order Start -->
            <section id="special-order" class="special-order">
                <div class="container-fluid">
                    <div class="container py-5">
                        <div class="section-title">
                            <h1>Special Order</h1>
                            <h3 class="text-muted">Pick Special Order From Wholesalers</h3>
                        </div>
                        <div class="rounded-2 bg-image my-2 py-5">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                </div>
                                <div class="col-12 col-md-6 p-5">
                                    <div class="mb-3">
                                        <h1 class="text-orange">Special Order</h1>
                                    </div>
                                    <div class="mb-3">
                                        <h4 class="text-white-50">Free on all your order, Free Shipping and 30 days money-back guarantee</h4>
                                    </div>
                                    <div class="mb-3">
                                        <a class="btn btn-primary py-2 px-2 fw-bold text-white fs-4 rounded-pill" href="special-order.php">Order Now <i class="bx bx-right-arrow-alt bx-sm"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Special Order End -->
            <!-- Retailer Home End -->

        <?php } elseif ($user_type == "wholesaler") { ?>

            <!-- Wholesaler Home Start -->
            <div class="container-fluid product">
                <div class="container py-5">
                    <div class="section-title">
                        <h1>Orders</h1>
                        <h3 class="text-muted">Manage Your Orders</h3>
                    </div>
                    <div class="tab-class">
                        <div class="row g-4">
                            <!-- Tabs -->
                            <div class="col-12 col-md-6 text-end">
                                <ul class="nav nav-pills text-center mb-5">
                                    <div class="btn-group">
                                        <li class="nav-item">
                                            <a class="d-flex py-2 px-2 fw-bold bg-light active" data-bs-toggle="pill" href="#shipping-tab">
                                                <span class="text-dark">Shipping Stage</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="d-flex py-2 px-2 fw-bold bg-light" data-bs-toggle="pill" href="#delivary-tab">
                                                <span class="text-dark">Delivery Stage</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="d-flex py-2 px-2 fw-bold bg-light" data-bs-toggle="pill" href="#receive-tab">
                                                <span class="text-dark">Receive Stage</span>
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div id="shipping-tab" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="row g-4" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                                            <div class="col-12 col-md-4">
                                                <div class="position-relative">
                                                    <div class="order-number text-center p-2 border border-primary border-1 rounded-2 mb-3">
                                                        <span><strong>Order Number:</strong> #<?= "2365488" ?></span>
                                                    </div>
                                                    <div class="order-details border border-gray border-1 rounded-2 p-3">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT NAME:</label>
                                                                <p>Green Capsicum</p>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT CATEGORY:</label>
                                                                <p>Vegetables</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label"> DESIRED PRICE:</label>
                                                                <p> 14.00</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">QUANTITY:</label>
                                                                <p>200</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">RE-RECEIVED DATE:</label>
                                                                <p> 25/12/2024</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">SCHEDULE OPTION:</label>
                                                                <p>Weekly</p>

                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">DESCRIPTION:</label>
                                                            <p> The product should be in medium size and the color be good</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-accent">Issues</button>
                                                            <button type="button" class="btn btn-secondary">Send Message</button>
                                                            <button type="button" class="btn btn-primary">Go To Delivary</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div id="delivary-tab" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="row g-4" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                                            <div class="col-12 col-md-4">
                                                <div class="position-relative">
                                                    <div class="order-number text-center p-2 border border-primary border-1 rounded-2 mb-3">
                                                        <span><strong>Order Number:</strong> #<?= "2365488" ?></span>
                                                    </div>
                                                    <div class="order-details border border-gray border-1 rounded-2 p-3">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT NAME:</label>
                                                                <p>Green Capsicum</p>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT CATEGORY:</label>
                                                                <p>Vegetables</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label"> DESIRED PRICE:</label>
                                                                <p> 14.00</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">QUANTITY:</label>
                                                                <p>200</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">RE-RECEIVED DATE:</label>
                                                                <p> 25/12/2024</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">SCHEDULE OPTION:</label>
                                                                <p>Weekly</p>

                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">DESCRIPTION:</label>
                                                            <p> The product should be in medium size and the color be good</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-accent">Issues</button>
                                                            <button type="button" class="btn btn-secondary">Send Message</button>
                                                            <button type="button" class="btn btn-primary">Go To Delivary</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">

                            <div id="receive-tab" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="row g-4" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                                            <div class="col-12 col-md-4">
                                                <div class="position-relative">
                                                    <div class="order-number text-center p-2 border border-primary border-1 rounded-2 mb-3">
                                                        <span><strong>Order Number:</strong> #<?= "2365488" ?></span>
                                                    </div>
                                                    <div class="order-details border border-gray border-1 rounded-2 p-3">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT NAME:</label>
                                                                <p>Green Capsicum</p>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">PRODUCT CATEGORY:</label>
                                                                <p>Vegetables</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label"> DESIRED PRICE:</label>
                                                                <p> 14.00</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">QUANTITY:</label>
                                                                <p>200</p>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">RE-RECEIVED DATE:</label>
                                                                <p> 25/12/2024</p>

                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                <label class="form-label">SCHEDULE OPTION:</label>
                                                                <p>Weekly</p>

                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">DESCRIPTION:</label>
                                                            <p> The product should be in medium size and the color be good</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="button" class="btn btn-accent">Issues</button>
                                                            <button type="button" class="btn btn-secondary">Send Message</button>
                                                            <button type="button" class="btn btn-primary">Go To Delivary</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


            <!-- Wholesaler Home End -->
        <?php } else { ?>

            <!--    Alter Warning Start  -->
            <div class="container py-5">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bx bx-data bx-lg"></i>
                        <p><strong>No Data Found Enter At Later Time</strong></p>
                        <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <!--    Alter Warning End   -->


        <?php } ?>

        </main>


        <!--    Include Footer   -->

        <?php include('assets/inc/footer.php') ?>