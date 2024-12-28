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



    $sender_id = $user_id ?? null;
    $receiver_id = $_GET['wsid'] ?? $_GET['rtid'] ?? null;
    $soid = $_GET['soid'] ?? null;


    // Special Order ID Unset
    if (!isset($soid)) {

        $stmt = $conn->prepare("SELECT DISTINCT CSENDER, CSOID FROM chats WHERE CRECEIVER = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $chats = $result->fetch_all(MYSQLI_ASSOC);

        // Special Order ID Set
    } else {

        $stmt = $conn->prepare("SELECT SONUMBER FROM special_orders WHERE SOID = ?");
        $stmt->bind_param("i", $soid);
        $stmt->execute();
        $stmt->store_result();
        // Bind the result
        $stmt->bind_result($sonumber);
        $stmt->fetch();
    }

    $stmt = $conn->prepare("SELECT FNAME, LNAME FROM users WHERE ID = ?");
    $stmt->bind_param("i", $receiver_id);
    $stmt->execute();
    $stmt->store_result();
    // Bind the result
    $stmt->bind_result($fname, $lname);
    $stmt->fetch();

    $stmt->close();



    $_SESSION['chatSender'] = $sender_id ?? null;
    $_SESSION['chatReceiver'] = $receiver_id ?? null;
    $_SESSION['chatSoid'] = $soid ?? null;
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
                    <?php if (isset($receiver_id)) { ?>
                        <!--    Chat Region Start -->
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <form id="chat-form" action="#">
                                    <!-- Chat Header -->
                                    <div class="chat-info text-center p-2 border border-primary border-2 rounded-2 mb-3">
                                        <p>
                                            <span class="fw-bold"><i class="bx bx-user bx-sm"></i> <?= ucfirst($user_type === 'retailer' ? 'wholesaler' : 'retailer') ?> Name: <?= ucfirst($fname) . " " . ucfirst($lname) ?>
                                                <span class="mx-2 d-block d-sm-inline"></span>
                                                <span class="fw-bold"><i class="bx bx-package bx-sm"></i> Order Number:</span> #<?= $sonumber ?>
                                        </p>
                                        <?= isset($_GET['wsid']) ? '<a href="my-orders.php">Back</a>' : '<a href="chat.php">Back</a>' ?>
                                    </div>

                                    <!-- Chat Body -->
                                    <div id="chat-body" class="border border-gray border-1 border-bottom-0 p-3 rounded-top" style="min-height: 40vh; max-height: 60vh; overflow-y: auto;">

                                    </div>

                                    <!-- Chat Input -->
                                    <div class="bg-white p-3 pt-0 border border-gray border-1 border-top-0 rounded-bottom">
                                        <div class="d-flex">
                                            <div id="typing-area" class="flex-grow-1 me-2">
                                                <input id="chat-sender" type="hidden" name="chat-sender" value="<?= $sender_id ?>" />
                                                <input id="chat-receiver" type="hidden" name="chat-receiver" value="<?= $receiver_id ?>" />
                                                <input id="chat-soid" type="hidden" name="chat-soid" value="<?= $soid ?>" />
                                                <input id="chat-input" class="form-control rounded-pill" type="text" name="chat-input" placeholder="Type a message..." />
                                            </div>
                                            <button id="send-btn" class="btn btn-primary rounded-pill" type="submit" name="send" disabled>
                                                <span class="d-none d-md-inline">Send</span>
                                                <i class="bx bx-paper-plane bx-sm"></i>
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        </div>
        <!--    Chat Region End -->
    <?php } elseif ($user_type === 'wholesaler') { ?>
        <!--    Users Chat Section    -->
        <div class="card-container" style="overflow-y: auto; max-height: 70vh;">
            <?php $count = 1; ?>
            <?php foreach ($chats as $chat) : ?>
                
                <?php
                    $stmt = $conn->prepare("SELECT FNAME, LNAME, USER_TYPE FROM users WHERE ID = ?");
                    $retailer_id = $chat['CSENDER'];
                    $stmt->bind_param("i", $retailer_id);
                    $stmt->execute();
                    $stmt->store_result();
                    // Bind the result
                    $stmt->bind_result($fname, $lname, $user_type);
                    $stmt->fetch();
                ?>
                <div class="card col-12 border border-1 border-white-50 mb-3 p-3" data-aos="slide-right" data-aos-duration="<?= $count++ ?>000">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card-body">
                                <h4 class="card-title"><?= ucfirst($fname) . " " . ucfirst($lname) ?></h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 align-content-center">
                            <div class="text-center text-md-end">
                                <a class="btn btn-primary" href="chat.php?rtid=<?= $retailer_id ?>&soid=<?= $chat['CSOID'] ?>">Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--    Users Chat Section  -->

    <?php } ?>
    <!--    Chat Section End -->
    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>