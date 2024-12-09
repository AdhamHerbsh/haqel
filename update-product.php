    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

    <main>
        <?php

        // Get UserID from session
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Check if the user ID is valid
        if ($user_id === null | $user_type != "wholesaler") {
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

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }


        ?>
        <!--    Update Product Section Start     -->
        <section id="" section="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title">
                        <h1>Edit Product</h1>
                        <h3 class="text-muted">Edit The Details Of Product</h3>
                    </div>
                    <div class="my-3">
                        <h5> Edit Product Details</h5>
                    </div>
                    <form class="p-4 border border-1 rounded-2" action="assets/php/product.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="pid" value="<?= $pid ?>" />
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pname" class="form-label">PRODUCT:</label>
                                    <select class="form-select form-select-lg" name="pname" id="pname" required>
                                        <option value="apple" <?= ($pname == "apple")? "selected" : "" ?>>Apple</option>
                                        <option value="mango" <?= ($pname == "mango")? "selected" : "" ?>>Mango</option>
                                        <option value="banana" <?= ($pname == "banana")? "selected" : "" ?>>Banana</option>
                                        <option value="orange" <?= ($pname == "orange")? "selected" : "" ?>>Orange</option>
                                        <option value="grape" <?= ($pname == "grape")? "selected" : "" ?>>Grape</option>
                                        <option value="watermelon" <?= ($pname == "watermelon")? "selected" : "" ?>>Watermelon</option>
                                        <option value="pear" <?= ($pname == "pear")? "selected" : "" ?>>Pear</option>
                                        <option value="strawberry" <?= ($pname == "strawberry")? "selected" : "" ?>>Strawberry</option>
                                        <option value="pomegranate" <?= ($pname == "pomegranate")? "selected" : "" ?>>Pomegranate</option>
                                        <option value="kiwi" <?= ($pname == "kiwi")? "selected" : "" ?>>Kiwi</option>
                                        <option value="green-papper" <?= ($pname == "green")? "selected" : "" ?>>Green Pepper</option>
                                        <option value="cucumber" <?= ($pname == "cucumber")? "selected" : "" ?>>Cucumber</option>
                                        <option value="onion" <?= ($pname == "onion")? "selected" : "" ?>>Onion</option>
                                        <option value="cilantro" <?= ($pname == "cilantro")? "selected" : "" ?>>Cilantro</option>
                                        <option value="green-chili" <?= ($pname == "green")? "selected" : "" ?>>Green Chili</option>
                                        <option value="peas" <?= ($pname == "peas")? "selected" : "" ?>>Peas</option>
                                        <option value="eggplant" <?= ($pname == "eggplant")? "selected" : "" ?>>Eggplant</option>
                                        <option value="carrot" <?= ($pname == "carrot")? "selected" : "" ?>>Carrot</option>
                                        <option value="potato" <?= ($pname == "potato")? "selected" : "" ?>>Potato</option>
                                        <option value="tomato" <?= ($pname == "tomato")? "selected" : "" ?>>Tomato</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pcategory" class="form-label">CATEGORY:</label>
                                    <select class="form-select form-select-lg" name="pcategory" id="pcategory" required>
                                        <option disabled selected value>Select Category:</option>
                                        <option value="fruits" <?= ($pcategory == "fruits")? "selected" : "" ?>>Fruits</option>
                                        <option value="vegetables" <?= ($pcategory == "vegetables")? "selected" : "" ?>>Vegetables</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pprice" class="form-label">PRICE:</label>
                                    <input type="number" class="form-control" name="pprice" id="pprice" value="<?= $pprice ?>" min="1" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">STOCK STATUS:</label>
                                    <div class="my-3">
                                        <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="pstatus" id="radio-not-available" value="unvailable"<?= ($pstatus == "unavailable")? "checked" : "" ?>  required/> <label class="form-check-label" for="radio-not-available">Not Available</label> </div>
                                        <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="pstatus" id="radio-available" value="available" <?= ($pstatus == "available")? "checked" : "" ?> required/> <label class="form-check-label" for="radio-available">Available</label> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pkeywords" class="form-label">KEYWORDS:</label>
                                    <input type="text" class="form-control" name="pkeywords" id="pkeywords" value="<?= $pkeywords ?>"/>
                                    <div id="highlighted-keywords" class="mt-3"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">QUANTITY:</label>
                                    <div class="mb-3">
                                        <div class="input-group quantity bg-white rounded-pill" style="width: 150px;">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control py-1 mx-2 text-center border-0" name="pquantity" value="<?= $pquantity?>" min="1" required>
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
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
                                    <textarea class="form-control" name="pdescription" id="pdescription" rows="3"><?= $pdescription ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="reset" name="cancel" id="cancel-btn" class="btn btn-accent"> Cancel </button>
                                <span class="mx-2"></span>
                                <button type="submit" name="save" id="save-btn" class="btn btn-primary"> Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--    Update Product Section End     -->

    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>