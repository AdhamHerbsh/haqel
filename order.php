<!--    Include Header File     -->
<?php include('assets/inc/header.php') ?>

<!--    Include Loader File     -->
<?php include('assets/inc/loader.php') ?>

<!--    Include Navbar File     -->
<?php include('assets/inc/nav.php') ?>

<?php

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;
$status = "";

if ($user_id === null || $user_type !== 'retailer') {
    header("Location: 404.php");
    exit();
}

$order_id = $_GET['oid'] ?? 0;
$special_order_id = $_GET['soid'] ?? 0;

$_SESSION['standardOrder'] = $_SESSION['standardOrder'] ?? [];
$_SESSION['specialOrder'] = $_SESSION['specialOrder'] ?? [];
$_SESSION['wholesaler'] = $_SESSION['wholesaler'] ?? [];


if ($order_id > 0) {
    $stmt = $conn->prepare("SELECT OID, OSTATUS, OSTAGE, WS_ID FROM orders WHERE OID = ?");
    $stmt->bind_param('i', $order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        if ($order) {
            $_SESSION['standardOrder'][$order_id] = $order;
        }
    }
    $stmt->close();
} elseif ($special_order_id > 0) {
    $stmt = $conn->prepare("SELECT SOID, SONUMBER, SOSTATUS, CONTRACT_FILE, WS_ID FROM special_orders WHERE SOID = ?");
    $stmt->bind_param('i', $special_order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $special_order = $result->fetch_assoc();
        if ($special_order) {
            $_SESSION['specialOrder'][$special_order_id] = $special_order;

            $wholesaler_id = (int)$special_order['WS_ID'];
            if ($wholesaler_id > 0) {
                $stmt_wholesaler = $conn->prepare("SELECT BUSINESS_NAME, COVERAGE_AREAS FROM account WHERE user_id = ?");
                $stmt_wholesaler->bind_param('i', $wholesaler_id);

                if ($stmt_wholesaler->execute()) {
                    $result_wholesaler = $stmt_wholesaler->get_result();
                    $wholesaler = $result_wholesaler->fetch_assoc();
                    if ($wholesaler) {
                        $_SESSION['wholesaler'][$wholesaler_id] = $wholesaler;
                    }
                }
                // Prepare SQL to get rate of wholesaler
                $stmt = $conn->prepare("SELECT RATE FROM reviews WHERE WS_ID = ?");
                $stmt->bind_param("s", $wholesaler_id);
                $stmt->execute();
                $stmt->store_result();    
                // Bind the result
                $stmt->bind_result($rate);
                $stmt->fetch();

                $stmt_wholesaler->close();
            }
        }
    }
    
    
    $stmt->close();

}

?>
<main>
    <section id="" class="">
        <!--    Order Details Section Start     -->
        <!--    Review and Feedback Section Start     -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="section-title mb-3">
                    <h1>Order Details</h1>
                    <h3 class="text-muted">Apply Offers and Track Order</h3>
                </div>
                <?php if ($special_order_id > 0) { ?>
                    <div class="card-container">
                        <?php $status = $_SESSION['specialOrder'][$special_order_id]['SOSTATUS'] ?? ''; ?>
                        <?php if ($status === 'approved') { ?>
                            <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="card-body">
                                            <h4 class="card-title"><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_NAME'] ?? 'Unknown Wholesaler') ?></h4>
                                            <p><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['COVERAGE_AREAS'] ?? 'Unknown Coverage Area') ?></p>
                                            <div class="d-flex star-rating" data-stars="<?= isset($rate)? $rate : "" ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 align-content-center">
                                        <div class="d-flex flex-column flex-md-row justify-content-around align-items-end">
                                            <a class="btn btn-secondary m-1" href="view-file.php?contract=<?= urlencode($_SESSION['specialOrder'][$special_order_id]['CONTRACT_FILE'] ?? 'File Not Found') ?>">View Contract</a>
                                            <a class="btn btn-danger m-1" href="">Reject</a>
                                            <form class="d-flex" action="assets/php/request.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="soid" value="<?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['SOID'] ?? 0) ?>">
                                                <input type="file" class="form-control" name="contract_file" id="contract_file" placeholder="No File Chosen" required/>
                                                <span class="mx-2"></span>
                                                <button class="btn btn-primary m-1" type="submit" name="apply-submit">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } elseif ($status === 'applied') { ?>
                            <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                                <div class="row">
                                    <div class="col-8 col-md-10">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                <p><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_NAME'] ?? 'Unknown Wholersaler') ?></p>
                                            </h4>
                                            <p><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['COVERAGE_AREAS'] ?? 'Unknown Coverage Area') ?></p>
                                            <div class="d-flex star-rating" data-stars="<?= isset($rate)? $rate : "" ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2 align-content-center">
                                        <div class="text-end">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <a class="btn btn-secondary" href="chat.php?wsid=<?= $wholesaler_id ?>&soid=<?= $special_order_id ?>">Chat</a>
                                                </div>
                                                <div class="col mb-3">
                                                    <form action="assets/php/request.php" method="POST">
                                                        <input type="hidden" name="soid" value="<?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['SOID'] ?? 0) ?>">
                                                        <button class="btn btn-primary" type="submit" name="finish-submit">Finished</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <?php if ($status !== 'finished') { ?>
                                <!-- Order Not Found Start -->
                                <!--    Alter Warning Start  -->
                                <div class="container py-5">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-timer bx-lg"></i>
                                            <p><strong>Order Didn't Approved Yet!</strong> Wait for Approved Or</p>
                                            <strong>Contact With Provider</strong>
                                            <a href="providers.php" class="alert-link p-2 border border-accent rounded-circle mb-3"><i class="bx bx-support bx-sm"></i></a>
                                            <a class="mb-3 btn btn-accent" href="my-orders.php">My Orders</a>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                                <!--    Alter Warning End   -->
                                <!-- Order Not Found End -->
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <!--    Special Order Requests Section  -->
                <?php } elseif ($order_id > 0) { ?>
                    <?php $status = $_SESSION['standardOrder'][$order_id]['OSTATUS'] ?? ''; ?>
                    <?php $stage = $_SESSION['standardOrder'][$order_id]['OSTAGE'] ?? ''; ?>
                    <?php if ($status === 'approved') { ?>

                        <!--    Track Order Section  -->
                        <div class="row text-center justify-content-evenly align-items-center">
                            <div class="col-12 col-md-3 position-relative p-5">
                                <div class="border border-2 <?= ($stage !== '') ? 'border-primary' : 'border-gray' ?> rounded-circle p-4 mb-3">
                                    <img class="img-fluid w-100" src="assets/img/icons/icons8-product-96.png" alt="image not found" />
                                </div>
                                <div class="mb-3">
                                    <h4>Shipping Step</h4>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-6 <?= ($stage !== '') ? 'bg-primary-50' : 'bg-gray text-white' ?> py-1 rounded">
                                        <span>
                                            <?= htmlspecialchars(($stage !== '') ? "Done" : "Pending") ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <i class="d-none d-md-block bx bx-right-arrow-alt bx-md"></i>
                                <i class="d-block d-md-none bx bx-down-arrow-alt bx-md"></i>
                            </div>
                            <div class="col-12 col-md-3 position-relative p-5">
                                <div class="border border-2 <?= ($stage === 'delivery' | $stage === 'receive' | $stage === 'done') ? 'border-primary' : 'border-gray' ?> rounded-circle p-4 mb-3">
                                    <img class="img-fluid w-100" src="assets/img/icons/icons8-truck-96.png" alt="image not found" />
                                </div>
                                <div class="mb-3">
                                    <h4>Delivery Step</h4>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-6 <?= ($stage === 'delivery' | $stage === 'receive' | $stage === 'done') ? 'bg-primary-50' : 'bg-gray text-white' ?> py-1 rounded">
                                        <span>
                                            <?= htmlspecialchars(($stage === 'delivery' | $stage === 'receive' | $stage === 'done') ? "Done" : "Pending") ?>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-1">
                                <i class="d-none d-md-block bx bx-right-arrow-alt bx-md"></i>
                                <i class="d-block d-md-none bx bx-down-arrow-alt bx-md"></i>
                            </div>
                            <div class="col-12 col-md-3 position-relative p-5">
                                <div class="border border-2 <?= ($stage === 'receive' | $stage === 'done') ? 'border-primary' : 'border-gray' ?> rounded-circle p-4 mb-3">
                                    <img class="img-fluid w-100" src="assets/img/icons/icons8-contactless-delivery-96.png" alt="image not found" />
                                </div>
                                <div class="mb-3">
                                    <h4>Receive Step</h4>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="col-6 <?= ($stage === 'receive' | $stage === 'done') ? 'bg-primary-50' : 'bg-gray text-white' ?> py-1 rounded">
                                        <span>
                                            <?= htmlspecialchars(($stage === 'receive' | $stage === 'done') ? "Done" : "Pending") ?>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--    Track Order Section  -->
                    <?php } else { ?>
                        <!-- Order Not Found Start -->
                        <!--    Alter Warning Start  -->
                        <div class="container py-5">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-timer bx-lg"></i>
                                    <p><strong>Order Didn't Approved Yet!</strong> Wait for Approved Or</p>
                                    <strong>Contact With Provider</strong>
                                    <a href="providers.php" class="alert-link p-2 border border-accent rounded-circle mb-3"><i class="bx bx-support bx-sm"></i></a>
                                    <a class="mb-3 btn btn-accent" href="my-orders.php">My Orders</a>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        <!--    Alter Warning End   -->
                        <!-- Order Not Found End -->
                    <?php }  ?>
                <?php } else { ?>
                    <!-- Order Didn't Approved Yet Start -->
                    <!--    Alter Default Start  -->
                    <div class="container py-5">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bx bx-x bx-lg"></i>
                                <p><strong>Order Not Found Go To My Orders Page and Choose One</strong></p>
                                <a class="mb-3 btn btn-primary" href="my-orders.php">My Orders</a>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    <!--    Alter Default End   -->
                    <!-- Order Didn't Approved Yet End -->
                <?php } ?>

            </div>
        </div>
        <!--    Order Details Section End     -->
        <?php if ($order_id > 0 && $stage === 'done') { ?>
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
                        <form action="assets/php/review.php" method="POST">
                            <input type="hidden" name="oid" value="<?= htmlspecialchars($_SESSION['standardOrder'][$order_id]['OID'] ?? 0) ?>">
                            <input type="hidden" name="wsid" value="<?= htmlspecialchars($_SESSION['standardOrder'][$order_id]['WS_ID'] ?? 0) ?>">
                            <div class="col-3 mb-3">
                                <label for="rate" class="form-label">RATE:</label>
                                <input class="form-range" min="0" max="5" type="range" name="rate" id="rate" placeholder="rate" />
                                <p class="text-muted">Rate Wholesaler From 1 → 5</p>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">MESSAGE:</label>
                                <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Write Message About The Order Trip"></textarea>
                            </div>
                            <div class="mb-3 text-end">
                                <a class="btn btn-accent" type="reset" href="home.php">Home</a>
                                <button class="btn btn-primary" type="submit" name="closed-submit">Send and Close Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--    Review and Feedback Section Start     -->
        <?php } ?>
    </section>
</main>

<!--    Include Footer   -->
<?php include('assets/inc/footer.php') ?>