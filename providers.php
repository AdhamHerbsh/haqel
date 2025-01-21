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
    // Prepare SQL to fetch user and account data
    $stmt = $conn->prepare("
    SELECT 
        u.ID,
        u.USERNAME, 
        u.FNAME, 
        u.LNAME, 
        u.PHONE, 
        u.USER_TYPE, 
        a.BUSINESS_NAME, 
        a.BUSINESS_EMAIL, 
        a.BUSINESS_TYPE, 
        a.BUSINESS_SEGMENT, 
        a.COMMERCIAL_REGISTER_FILE,
        a.RATE
    FROM 
        users u
    LEFT JOIN 
        account a 
    ON 
        u.ID = a.user_id
    WHERE USER_TYPE LIKE 'wholesaler'

");

    // Bind user_id as an integer
    $stmt->execute();

    // Fetch data as an associative array
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
?>

    <!--    User Profile Section Start     -->
    <main>
        <section id="" class="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title mb-3">
                        <h1>Our Providers</h1>
                        <h3 class="text-muted">See Best Of Wholesalers On Website</h3>
                    </div>
                    <div class="card-container">
                        <div class="row">
                            <?php foreach ($users as $user) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="card border-primary text-center mb-2">
                                        <div class="card-icon mb-3">
                                                <i class="bx bx-group bx-xxxlg"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <h4 class="card-title"><?= htmlspecialchars($user['FNAME'] . " " . $user['LNAME']); ?></h4>
                                            </div>
                                            <div class="mb-3">
                                                <p class="card-title"><?= htmlspecialchars(ucfirst($user['BUSINESS_TYPE'])); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <?php if($user['RATE'] !== 0){ ?>
                                                    <div class="star-rating" data-stars="<?= $user['RATE'] ?>"></div>
                                                <?php }else{ ?>
                                                    <i class='bx bx-message-alt-x bx-sm'></i>
                                                <?php } ?>
                                            </div>
                                            <div class="my-3">
                                                <div class="d-flex justify-content-evenly">
                                                    <a class="btn btn-accent fs-6 fw-bold" href="users-list.php">More Info</a>
                                                    <a class="btn btn-primary fs-6 fw-bold" href="chat.php?wsid=<?= $user['ID'] ?>&soid=<?= $user_id . $user['ID'] ?>">Chat</a>
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
    </main>
    <!--    User Profile Section End     -->

<?php
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>