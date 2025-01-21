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
if ($user_id === null | $user_type != "retailer") {
    header("Location: 404.php"); // Redirect to 404 page if user is not logged in
    exit();
}

?>

<main>
    <section id="cart" class="cart">
        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title mb-3">
                    <h1>Cart</h1>
                    <h3 class="text-muted">Choose Products And Place Order</h3>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="alert alert-warning d-none" role="alert">
                            <strong>Alert Heading</strong> This is a warning alert—check it out!
                        </div>

                        <div class="table-responsive p-4 my-2 rounded-2 border border-1 border-white-50 overflow-hidden">
                            <table id="productsTable" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">####</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Wholesaler</th>
                                    </tr>
                                </thead>
                                <!-- Cart Products Section -->
                                <?php $totalPrice = 0; ?>
                                <?php if (isset($_SESSION['cart'])) { ?>
                                    <tbody>
                                        <?php foreach ($_SESSION['cart'] as $pid => $item) : ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center" style="max-width: 80px;">
                                                        <img src="<?= $item['PIMAGE'] ?>" class="img-fluid me-5 rounded-circle p-2" alt="<?= $item['PNAME'] ?>">
                                                    </div>
                                                </th>
                                                <td>
                                                    <p class="mb-0 mt-4"><?= ucfirst($item['PNAME']) ?></p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4"><?= $item['PPRICE'] ?></p>
                                                </td>
                                                <td>
                                                    <div class="input-group quantity bg-white rounded-pill py-3" style="width: 130px;">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border qty-btn" type="button">
                                                                <i class="bx bx-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input id="pid-input" type="hidden" name="pid" value="<?= $item['PID'] ?>">
                                                        <input id="pname-input" type="hidden" name="pname" value="<?= $item['PNAME'] ?>">
                                                        <input id="pprice-input" type="hidden" name="pprice" value="<?= $item['PPRICE'] ?>">
                                                        <input id="pimage-input" type="hidden" name="pimage" value="<?= $item['PIMAGE'] ?>">
                                                        <input id="puser_id-input" type="hidden" name="puser_id" value="<?= $item['PUSER_ID'] ?>">
                                                        <input id="pwholesaler-input" type="hidden" name="pwholesaler" value="<?= $item['PWHOLESALER'] ?>">
                                                        <input id="qty-input" type="text" class="form-control form-control-sm text-center border-0" name="quantity" value="<?= $item['QUANTITY'] ?>">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border qty-btn" type="button">
                                                                <i class="bx bx-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4"><?= $item['PWHOLESALER'] ?></p>
                                                </td>
                                            </tr>
                                            <?php $itemTotalPrice = $item['PPRICE'] * $item['QUANTITY']; ?>
                                            <?php $totalPrice += $itemTotalPrice; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                <?php } else { ?>
                                    <!--    Alter Warning Start  -->
                                    <div class="container py-5">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bx bx-data bx-lg"></i>
                                                <p><strong>No Data Found Enter At Least One Product</strong></p>
                                                <a class="mb-3 btn btn-primary" href="home.php">Pick Product</a>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                    <!--    Alter Warning End   -->
                                <?php } ?>
                            </table>
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-white border border-1" href="home.php">Return To Home</a>
                                <div>
                                    <a class="btn btn-accent <?= isset($_SESSION['cart']) ? "" : "disabled" ?>" href="assets/php/cart.php?action=clear" role="button"><i class="bx bx-trash bx-sm"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <form id="standard-order" class="p-4 my-2 rounded-2 border border-1 border-white-50">
                            <h4>Order</h4>
                            <div class="row">
                                <div class="col-4">
                                    <!--    Order Type Start   -->
                                    <input type="hidden" name="otype" value="standard" />
                                    <!--    Order Type End     -->
                                    <div class="mb-3">
                                        <label for="" class="form-label">Payment Method:</label>
                                        <div class="mb-3">
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="pay_method" id="radio-pay_method_cash" value="cash" required /> <label class="form-check-label" for="radio-pay_method_cash"> Cash on Deliver</label> </div>
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="pay_method" id="radio-pay_method_later" value="later" required /> <label class="form-check-label" for="radio-pay_method_later">Buy Now, Pay Later</label> </div>
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="pay_method" id="radio-pay_method_credit" value="credit" required /> <label class="form-check-label" for="radio-pay_method_credit">Credit</label> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Delivery Options:</label>
                                        <div class="mb-3">
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="delivery_option" id="radio-delivery_option_logistic_shipping" value="logistic_shipping" required /> <label class="form-check-label" for="radio-delivery_option_logistic_shipping">Logistic Shipping</label> </div>
                                            <div class="form-check"> <input class="form-check-input" type="radio" name="delivery_option" id="radio-delivery_option_personal_recevice" value="personal_recevice" required /> <label class="form-check-label" for="radio-delivery_option_personal_recevice">Personal Receive</label> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between my-5">
                                <div class="col-6">
                                    <p class="fs-4 fw-bold">Total Price</p>
                                </div>
                                <div class="col-6">
                                    <span>
                                        <small>SAR</small>
                                        <input type="text" id="totalPrice" class="fs-4 fw-bold border-0 bg-transparent w-75 w-25" name="totalprice" value="<?= isset($totalPrice) ? (float)$totalPrice : 0.00 ?>" step="0.01" readonly />
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button id="submitBtn" class="col-12 btn btn-primary <?= isset($_SESSION['cart']) ? "" : "disabled" ?>" type="submit" name="standard-order">Checkout</button>
                                <a id="checkoutModel" class="col-12 btn btn-primary <?= isset($_SESSION['cart']) ? "" : "disabled" ?>" data-bs-toggle="modal" href="#checkout" role="button">Proceed To Checkout</a>
                            </div>
                            <!--   Checkout Modal Start -->
                            <div class="modal fade" id="checkout" aria-hidden="true" aria-labelledby="checkoutLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="checkoutLabel">
                                                Checkout <i class="bx bx-credit-card-alt"></i>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="cname" class="form-label">CARD HOLDER NAME:</label>
                                                    <input type="text" class="form-control" name="cname" id="cname" placeholder="Enter Name" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cnumber" class="form-label">CARD NUMBER:</label>
                                                    <input type="text" class="form-control" name="cnumber" id="cnumber" placeholder="0000 0000 0000 000" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cexdate" class="form-label">EXP/DATE:</label>
                                                    <input type="date" class="form-control" name="cexdate" id="cexdate" placeholder="00/00" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="cvc" class="form-label">CVC:</label>
                                                    <input type="number" class="form-control" name="cvc" id="cvc" placeholder="000" />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <img class="img-fluid w-100" src="assets/img/credit-card.png" alt="image not found">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="btn btn-accent fw-bold shadow-sm" data-bs-dismiss="modal" aria-label="Close">Cancle</button>
                                                <span class="mx-2"></span>
                                                <button class="col-12 btn btn-primary <?= isset($_SESSION['cart']) ? "" : "disabled" ?> shadow-sm" type="submit" name="standard-order" data-bs-dismiss="modal">Checkout</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--   Checkout Modal End -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->
    </section>
</main>

<!-- Include Footer -->
<?php include('assets/inc/footer.php'); ?>