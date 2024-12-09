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
    if ($user_id === null | $user_type != "retailer") {
        header("Location: 404.php"); // Redirect to 404 page if user is not logged in
        exit();
    }
    ?>

    <!--    Add Product Section Start     -->
    <section id="special-order" section="special-order">
        <div class="container-fluid py-5">
            <div class="container">
                <div class="section-title">
                    <h1>Special Order</h1>
                    <h3 class="text-muted"> Offer Your Special Order Here</h3>
                </div>
                <div class="my-3">
                    <h5>Enter Order Details</h5>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <form class="p-4 border border-1 rounded-2" action="assets/php/special-order.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="sopname" class="form-label">PRODUCT:</label>
                                        <select class="form-select form-select-lg" name="sopname" id="sopname" required>
                                            <option disabled selected value>Select Product:</option>
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
                                        <label for="sopcategory" class="form-label">CATEGORY:</label>
                                        <select class="form-select form-select-lg" name="sopcategory" id="sopcategory" required>
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
                                        <label for="sopprice" class="form-label">DESIRED PRICE:</label>
                                        <input type="number" class="form-control" name="sopprice" id="sopprice" placeholder="00" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">QUANTITY:</label>
                                        <div class="mb-3">
                                            <div class="input-group quantity bg-white rounded-pill" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" type="button">
                                                        <i class="bx bx-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm text-center border-0" name="sopquantity" value="1" min="1" required />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" type="button">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="sorecived_date" class="form-label">RECEIVED DATE:</label>
                                        <input type="date" class="form-control" name="sorecived_date" id="sorecived_date" placeholder="Write Keywords About Product" min="<?= date('Y-m-d') ?>" required />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="soschedule_option" class="form-label">SCHEDULE OPTIONS:</label>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="soschedule_option" id="radio-soschedule_option_daily" value="day" required /> <label class="form-check-label" for="radio-soschedule_option_daily">Daily</label> </div>
                                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="soschedule_option" id="radio-soschedule_option_weekly" value="week" required /> <label class="form-check-label" for="radio-soschedule_option_weekly">Weekly</label> </div>
                                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="soschedule_option" id="radio-soschedule_option_monthly" value="month" required /> <label class="form-check-label" for="radio-soschedule_option_monthly">Monthly</label> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="sodescription" class="form-label">DESCRIPTION:</label>
                                        <textarea class="form-control" name="sodescription" id="sodescription" rows="3" placeholder="Write Product Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <button type="reset" name="cancel" id="cancel" class="btn btn-accent"> Cancel </button>
                                <span class="m-2"></span>
                                <button type="submit" name="create" id="create" class="btn btn-primary"> Create </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-4 align-content-center">
                        <img class="img-fluid w-100 m-auto" src="assets/img/apple-box.png" alt="image not found" />
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--    Add Product Section End     -->

</main>

<!--    Include Footer   -->

<?php include('assets/inc/footer.php') ?>