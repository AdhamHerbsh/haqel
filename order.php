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
    $stmt = $conn->prepare("SELECT OID, ONUMBER, OSTATUS, OSTAGE, WS_ID, OSCHEDULE, ODAYS FROM orders WHERE OID = ?");
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
    // Fetch special order details
    $stmt = $conn->prepare("
        SELECT 
            SOID, SONUMBER, SOTYPE, SOSTATUS, PNAME, PCATEGORY, PPRICE, SOQUANTITY, SORECEIVEDDATE, 
            SOSCHEDULEOPTION, SODAYS, SODESCRIPTION, SOTOTALPRICE, SODATE, CONTRACT_FILE, USER_ID, WS_ID 
        FROM special_orders 
        WHERE SOID = ?
    ");
    $stmt->bind_param('i', $special_order_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $special_order = $result->fetch_assoc();
        if ($special_order) {
            $_SESSION['specialOrder'][$special_order_id] = $special_order;

            // Fetch requests associated with the wholesaler
            $stmt_req = $conn->prepare("
                SELECT RSOID, RCONTRACT_FILE, WS_ID 
                FROM requests WHERE RSOID = ? AND RSTATUS = 'unapplied'
            ");
            $stmt_req->bind_param('i', $special_order_id);

            if ($stmt_req->execute()) {
                $result = $stmt_req->get_result();
                $requests = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $requests = [];
            }
            $stmt_req->close();

            $wholesaler_id = (int)$special_order['WS_ID'];
            if ($wholesaler_id > 0) {
                // Fetch wholesaler details
                $stmt_wholesaler = $conn->prepare("
                    SELECT BUSINESS_NAME, BUSINESS_TYPE 
                    FROM account 
                    WHERE user_id = ?
                ");
                $stmt_wholesaler->bind_param('i', $wholesaler_id);

                if ($stmt_wholesaler->execute()) {
                    $result_wholesaler = $stmt_wholesaler->get_result();
                    $wholesaler = $result_wholesaler->fetch_assoc();
                    if ($wholesaler) {
                        $_SESSION['wholesaler'][$wholesaler_id] = $wholesaler;
                    }
                }

                $stmt_wholesaler->close();


                // Fetch wholesaler's average rate
                $stmt_rate = $conn->prepare("
                    SELECT AVG(RATE) AS average_rate 
                    FROM reviews 
                    WHERE WS_ID = ?
                ");
                $stmt_rate->bind_param('i', $wholesaler_id);

                if ($stmt_rate->execute()) {
                    $result_rate = $stmt_rate->get_result();
                    $rate_data = $result_rate->fetch_assoc();
                    $rate = $rate_data['average_rate'] ?? null;
                } else {
                    $rate = null;
                }
                $stmt_rate->close();
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
                <?php if ($order_id > 0) { ?>
                    <!-- Standard Order Start -->
                    <div class="container mb-3">
                        <!--    Special Order Title Start    -->
                        <div class="text-center">
                            <h2>Standard Order</h2>
                            <h6>Order ID: <?= $_SESSION['standardOrder'][$order_id]['ONUMBER']; ?></h6>
                        </div>
                        <!--    Special Order Title End    -->
                        <table class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Category</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Product Quantity</th>
                                    <th scope="col">Schedule Option</th>
                                    <th scope="col">Schedule Days</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM order_items WHERE OIOID = ?");
                                $stmt->bind_param('i', $order_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $order_items = $result->fetch_all(MYSQLI_ASSOC);

                                foreach ($order_items as $orderitem) :
                                    $stmt = $conn->prepare("SELECT PNAME, PCATEGORY FROM products WHERE PID = ?");
                                    $stmt->bind_param('i', $orderitem['OIPID']);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $stmt->bind_result($pname, $pcategory);
                                    $stmt->fetch();
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars(ucfirst($pname)); ?></td>
                                        <td><?= htmlspecialchars(ucfirst($pcategory)); ?></td>
                                        <td><?= htmlspecialchars($orderitem['OIQUANTITY']); ?></td>
                                        <td><?= htmlspecialchars($orderitem['OIPRICE']); ?></td>
                                        <td><?= htmlspecialchars($_SESSION['standardOrder'][$order_id]['OSCHEDULE']); ?></td>
                                        <td><?= htmlspecialchars($_SESSION['standardOrder'][$order_id]['ODAYS']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Standard Order End -->
                <?php } else { ?>
                    <!-- Special Order Start -->
                    <div class="container mb-3">
                        <!--    Special Order Title Start    -->
                        <div class="text-center">
                            <h2>Special Order</h2>
                            <h6>Special Order ID: <?= $_SESSION['specialOrder'][$special_order_id]['SONUMBER']; ?></h6>
                        </div>
                        <!--    Special Order Title End    -->
                        <table class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Category</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Product Quantity</th>
                                    <th scope="col">Schedule Option</th>
                                    <th scope="col">Schedule Days</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars(ucfirst($_SESSION['specialOrder'][$special_order_id]['PNAME'])); ?></td>
                                    <td><?= htmlspecialchars(ucfirst($_SESSION['specialOrder'][$special_order_id]['PCATEGORY'])); ?></td>
                                    <td><?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['PPRICE']); ?></td>
                                    <td><?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['SOQUANTITY']); ?></td>
                                    <td><?= htmlspecialchars(ucfirst($_SESSION['specialOrder'][$special_order_id]['SOSCHEDULEOPTION'])); ?></td>
                                    <td><?= htmlspecialchars(ucwords($_SESSION['specialOrder'][$special_order_id]['SODAYS'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Special Order End -->
                <?php } ?>
                <?php if ($special_order_id > 0) { ?>
                    <div class="card-container">
                        <?php $status = $_SESSION['specialOrder'][$special_order_id]['SOSTATUS'] ?? ''; ?>
                        <?php if ($status === 'unapproved') { ?>
                            <?php foreach ($requests as $request): ?>
                            <?php // Fetch wholesaler details
                            $stmt_wholesaler = $conn->prepare("
                                SELECT BUSINESS_NAME, BUSINESS_TYPE 
                                FROM account 
                                WHERE user_id = ?
                            ");
                                $stmt_wholesaler->bind_param('i', $request['WS_ID']);
                                $stmt_wholesaler->execute();
                                $result_wholesaler = $stmt_wholesaler->get_result();
                                $wholesaler = $result_wholesaler->fetch_assoc();
                               ?>
                            <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="card-body">
                                            <h4 class="card-title"><?= htmlspecialchars($wholesaler['BUSINESS_NAME'] ?? 'Unknown Wholesaler') ?></h4>
                                            <p><?= htmlspecialchars(ucfirst($wholesaler['BUSINESS_TYPE'] ?? 'Unknown Business Type')) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 align-content-center">
                                        <div class="d-flex flex-column flex-md-row justify-content-around align-items-end">
                                            <a class="btn btn-secondary m-1" href="view-file.php?contract=<?= urlencode($request['RCONTRACT_FILE'] ?? 'File Not Found') ?>">View Contract</a>
                                            <a class="btn btn-danger m-1" href="">Reject</a>
                                            <form class="d-flex" action="assets/php/request.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="soid" value="<?= htmlspecialchars($request['RSOID']) ?>">
                                                <input type="hidden" name="sonumber" value="<?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['SONUMBER']) ?>">
                                                <input type="hidden" name="wsid" value="<?= htmlspecialchars($request['WS_ID']) ?>">
                                                <input type="file" class="form-control" name="contract_file" id="contract_file" placeholder="No File Chosen" required />
                                                <span class="mx-2"></span>
                                                <button class="btn btn-primary m-1" type="submit" name="apply-submit">Apply</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php }elseif ($status === 'approved') { ?>
                            <div class="card col-12 border border-1 border-white-50 mb-3 p-3">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="card-body">
                                            <h4 class="card-title"><?= htmlspecialchars($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_NAME'] ?? 'Unknown Wholesaler') ?></h4>
                                            <p><?= htmlspecialchars(ucfirst($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_TYPE'] ?? 'Unknown Business Type')) ?></p>
                                            <div class="d-flex star-rating" data-stars="<?= isset($rate) ? $rate : "" ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 align-content-center">
                                        <div class="d-flex flex-column flex-md-row justify-content-around align-items-end">
                                            <a class="btn btn-secondary m-1" href="view-file.php?contract=<?= urlencode($_SESSION['specialOrder'][$special_order_id]['CONTRACT_FILE'] ?? 'File Not Found') ?>">View Contract</a>
                                            <a class="btn btn-danger m-1" href="">Reject</a>
                                            <form class="d-flex" action="assets/php/request.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="soid" value="<?= htmlspecialchars($_SESSION['specialOrder'][$special_order_id]['SOID'] ?? 0) ?>">
                                                <input type="file" class="form-control" name="contract_file" id="contract_file" placeholder="No File Chosen" required />
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
                                            <p><?= htmlspecialchars(ucfirst($_SESSION['wholesaler'][$wholesaler_id]['BUSINESS_TYPE'] ?? 'Unknown Business Type')) ?></p>
                                            <div class="d-flex star-rating" data-stars="<?= isset($rate) ? $rate : "" ?>"></div>
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
                        <div class="text-center">
                            <h2>Track Order</h2>
                            <h6>See the status of your order</h6>
                        </div>
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
                    <?php } elseif ($status !== 'closed') { ?>
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