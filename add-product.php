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
    if ($user_id === null | $user_type != "wholesaler") {
        header("Location: 404.php"); // Redirect to 404 page if user is not logged in
        exit();
    }

    // Prepare SQL to fetch user and account data
    $stmt = $conn->prepare("SELECT * FROM products WHERE USER_ID = $user_id");

    // Bind user_id as an integer
    $stmt->execute();

    // Fetch data as an associative array
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>

    <main>

        <!--    Add Product Section Start     -->
        <section id="" section="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title">
                        <h1>Add Product</h1>
                        <h3 class="text-muted">Add The Details Of Product</h3>
                    </div>
                    <div class="my-3">
                        <h5> Add Product Details</h5>
                    </div>
                    <?php
                    if (isset($_GET['action'])) {
                        if ($_GET['action'] == "success") {
                    ?>
                            <div class="alert alert-success" role="alert">
                                <i class='bx bx-check bx-md'></i>
                                <strong>Product Added Successfully</strong>
                            </div>
                        <?php
                        } elseif ($_GET['action'] == "edited") {
                        ?>
                            <div class="alert alert-secondary" role="alert">
                                <i class="bx bx-like bx-md"></i>
                                <strong>Product Edited Successfully</strong>
                            </div>
                        <?php
                        } elseif ($_GET['action'] == "deleted") {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="bx bx-trash bx-md"></i>
                                <strong>Product Deleted Successfully</strong>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <form class="p-4 border border-1 rounded-2" action="assets/php/product.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pname" class="form-label">PRODUCT:</label>
                                    <select class="form-select form-select-lg" name="pname" id="pname" required>
                                        <option disabled selected value>Select Product</option>
                                        <!-- Fruits -->
                                        <option value="apple">Apple</option>
                                        <option value="mango">Mango</option>
                                        <option value="banana">Banana</option>
                                        <option value="orange">Orange</option>
                                        <option value="grape">Grape</option>
                                        <option value="watermelon">Watermelon</option>
                                        <option value="pear">Pear</option>
                                        <option value="strawberry">Strawberry</option>
                                        <option value="pomegranate">Pomegranate</option>
                                        <option value="kiwi">Kiwi</option>
                                        <!-- Vegetables -->
                                        <option value="green-papper">Green Pepper</option>
                                        <option value="cucumber">Cucumber</option>
                                        <option value="onion">Onion</option>
                                        <option value="cilantro">Cilantro</option>
                                        <option value="green-chili">Green Chili</option>
                                        <option value="peas">Peas</option>
                                        <option value="eggplant">Eggplant</option>
                                        <option value="carrot">Carrot</option>
                                        <option value="potato">Potato</option>
                                        <option value="tomato">Tomato</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pcategory" class="form-label">CATEGORY:</label>
                                    <select class="form-select form-select-lg" name="pcategory" id="pcategory" required>
                                        <option disabled selected value>Select Category:</option>
                                        <option value="fruits">Fruits</option>
                                        <option value="vegetables">Vegetables</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pprice" class="form-label">PRICE:</label>
                                    <input type="number" class="form-control" name="pprice" id="pprice" placeholder="00" min="1" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">STOCK STATUS:</label>
                                    <div class="my-3">
                                        <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="pstatus" id="radio-not-available" value="unvailable" /> <label class="form-check-label" for="radio-not-available">Not Available</label> </div>
                                        <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="pstatus" id="radio-available" value="available" checked /> <label class="form-check-label" for="radio-available">Available</label> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pkeywords" class="form-label">KEYWORDS:</label>
                                    <input type="text" class="form-control" name="pkeywords" id="pkeywords" placeholder="Write Keywords About Product" />
                                    <div id="highlighted-keywords" class="mt-3"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">QUANTITY:</label>
                                    <div class="mb-3">
                                        <div class="input-group w-50 w-md-25 quantity bg-white rounded-pill py-3">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border qty-btn" type="button">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                            <input id="qty-input" type="text" class="form-control form-control-sm text-center border-0" name="quantity" value="1">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border qty-btn" type="button">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="pdescription" class="form-label">DESCRIPTION:</label>
                                    <textarea class="form-control" name="pdescription" id="pdescription" rows="3" placeholder="Write Product Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="reset" name="cancel" id="cancel-btn" class="btn btn-accent"> Cancel </button>
                                <span class="mx-2"></span>
                                <button type="submit" name="create" id="create-btn" class="btn btn-primary"> Create </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--    Add Product Section End     -->

        <!--    My Products Section Start     -->
        <section>
            <div class="container-fluid product">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                <?php foreach ($products as $product) : ?>
                                    <div class="col-12 col-md-4">
                                        <div class="border border-gray rounded-2 position-relative product-item">
                                            <div class="product-img">
                                                <img src="<?= $product['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="p-4">
                                                <p><?= $product['PNAME'] ?></p>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="text-dark fs-5 fw-bold"><small>SAR</small> <?= $product['PPRICE'] ?></p>
                                                        <p class="mb-0"><?= $product['PCATEGORY'] ?></p>
                                                        <p class="mb-0"><?= $product['PSTATUS'] ?></p>
                                                    </div>
                                                    <div class="col-6 d-flex justify-content-end align-items-center product-btn">
                                                        <a href="update-product.php?pid=<?= $product['PID'] ?>" class="btn btn-secondary rounded-circle"><i class="bx bx-edit bx-sm"></i></a>
                                                        <div class="mx-2"></div>
                                                        <a href="assets/php/product.php?pid=<?= $product['PID'] ?>&action=delete" class="btn btn-danger rounded-circle"><i class="bx bx-trash bx-sm"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!--    My Products Section End     -->

    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>