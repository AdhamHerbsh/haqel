
    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

<?php

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;

if ($user_id === null || $user_type !== 'retailer') {
    header("Location: 404.php");
    exit();
}

$order_id = $_GET['oid'] ?? 0;
$special_order_id = $_GET['soid'] ?? 0;

$_SESSION['order'] = $_SESSION['order'] ?? [];
$_SESSION['specialOrder'] = $_SESSION['specialOrder'] ?? [];
$_SESSION['wholesaler'] = $_SESSION['wholesaler'] ?? [];


if ($order_id > 0) {
    $stmt = $conn->prepare("SELECT OID, OSTATUS, OSTAGE FROM `orders` WHERE OID = ?");
    $stmt->bind_param('i', $order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        if ($order) {
            $_SESSION['order'][$order_id] = $order;
        }
    }
    $stmt->close();
} elseif ($special_order_id > 0) {
    $stmt = $conn->prepare("SELECT SOID, SOSTATUS, CONTRACT_FILE, WS_ID FROM `special_orders` WHERE SOID = ?");
    $stmt->bind_param('i', $special_order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $special_order = $result->fetch_assoc();
        if ($special_order) {
            $_SESSION['specialOrder'][$special_order_id] = $special_order;

            $wholesaler_id = (int)$special_order['WS_ID'];
            if ($wholesaler_id > 0) {
                $stmt_wholesaler = $conn->prepare("SELECT BUSINESS_NAME, COVERAGE_AREAS FROM `account` WHERE user_id = ?");
                $stmt_wholesaler->bind_param('i', $wholesaler_id);

                if ($stmt_wholesaler->execute()) {
                    $result_wholesaler = $stmt_wholesaler->get_result();
                    $wholesaler = $result_wholesaler->fetch_assoc();
                    if ($wholesaler) {
                        $_SESSION['wholesaler'][$wholesaler_id] = $wholesaler;
                    }
                }
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
                                            <div class="d-flex star-rating" data-stars="3"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 align-content-center">
                                        <div class="d-flex flex-column flex-md-row justify-content-around align-items-end">
                                            <a class="btn btn-primary m-1" href="view-file.php?contract=<?= urlencode($_SESSION['specialOrder'][$special_order_id]['CONTRACT_FILE'] ?? 'File Not Found') ?>">View Contract</a>
                                            <a class="btn btn-danger m-1" href="">Reject</a>
                                            <form class="d-flex">
                                                <input type="file" class="form-control" name="contract_file" id="comm_file" placeholder="No File Chosen" />
                                                <span class="mx-2"></span>
                                                <button class="btn btn-primary m-1" type="submit">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } elseif ($status === 'applied') { ?>
                            <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="card-body">
                                            <h4 class="card-title"><p><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_NAME'] ?? 'Unknown Wholersaler') ?></p>                                            </h4>
                                            <p><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['COVERAGE_AREAS'] ?? 'Unknown Coverage Area') ?></p>
                                            <div class="d-flex star-rating" data-stars="3"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 align-content-center">
                                        <div class="text-end">
                                            <a class="btn btn-primary" href="chat.php?wsid=<?= $wholesaler_id ?>">Chat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }elseif ($status === 'unapproved'){ ?>

                            <?php } ?>
                        </div>
                        <!--    Special Order Requests Section  -->
                        <?php } elseif ($order_id > 0) { ?>
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
                        <?php } else { ?>
                        <!-- Order Not Found Start -->
                        <!--    Alter Warning Start  -->
                        <div class="container py-5">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-x bx-lg"></i>
                                    <p><strong>Order Not Found Go To My Orders Page and Choose One</strong></p>
                                    <a class="mb-3 btn btn-primary" href="my-orders.php">My Order</a>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        <!--    Alter Warning End   -->

                        <!-- Order Not Found End -->
                    <?php } ?>

                </div>
            </div>
            <!--    Order Details Section End     -->
            <?php if($status === 'finished'){ ?>
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
                                <p class="text-muted">Rate Wholesaler From 1 → 5</p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">MESSAGE:</label>
                                <textarea class="form-control" name="" id="" cols="30" rows="10" placeholder="Write Message About The Order Trip"></textarea>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-accent" type="reset">Cancle</button>
                                <button class="btn btn-primary" type="submit">Send</button>
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