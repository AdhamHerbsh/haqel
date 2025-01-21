    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

    <?php    // Get UserID from session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Check if the user ID is valid

    if ($user_id === null | $user_type != "wholesaler") {
        // Redirect to 404 page if user is not logged in
        header("Location: 404.php");
        exit();
    }

    // Prepare SQL to fetch user and account data
    $stmt = $conn->prepare("SELECT *  FROM special_orders WHERE SOSTATUS = 'finished' AND WS_ID = ?");

    // Bind user_id as an integer
    $stmt->bind_param('i', $user_id);

    // Execute the query    
    $stmt->execute();

    // Fetch data as an associative array
    $result = $stmt->get_result();
    $special_orders = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>

    <main>
        <section id="" class="">
            <?php if ($user_type == "wholesaler") { ?>
                <!-- Wholesaler Requests Start -->
                <div class="container-fluid requests">
                    <div class="container py-5">
                        <div class="section-title mb-5">
                            <h1>Finished Special Orders</h1>
                            <h3 class="text-muted"> See Details Of Special Orders are Finished</h3>
                        </div>
                        <div class="table-responsive overflow-md-hidden mb-3">
                            <table class="table table-hover" id="ordersTable">
                                <thead>
                                    <tr>
                                        <div class="row text-black-50 border-bottom border-1">
                                            <div class="col-1 text-center align-content-center">
                                                <i class="bx bx-search-alt bx-md"></i>
                                            </div>
                                            <div class="col-11 form-floating">
                                                <input type="text" class="form-control border-0 text-black" name="search" id="search" placeholder="">
                                                <label for="search">Search</label>
                                            </div>
                                        </div>
                                    </tr>
                                    <tr>
                                        <th scope="col">Order Number</th>
                                        <th scope="col">Order Type</th>
                                        <th scope="col">Order Total Price</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Order Days</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">######</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach ($special_orders as $specialorder) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($specialorder['SONUMBER']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOTYPE']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOTOTALPRICE']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOSTARTDATE']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOENDDATE']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOSCHEDULEOPTION']); ?></td>
                                            <td><?= htmlspecialchars($specialorder['SOSTATUS']); ?></td>
                                            <td>
                                                <?php if ($specialorder['SOSTATUS'] !== 'closed') { ?>
                                                    <a class="btn btn-secondary" href="order.php?soid=<?= $specialorder['SOID'] ?>">Details <i class="bx bx-right-arrow-alt"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Wholesaler Requests End -->

            <?php } else { ?> <!--    Alter Warning Start  -->

                <div class="container py-5">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex flex-column align-items-center"> <i class="bx bx-error bx-lg"></i>
                            <p><strong>Wrong Url <i class="bx bx-link"></i> You Must Login Or Register To Access This Page !</strong></p>
                            <a class="mb-3 btn btn-primary" href="login.php">Login</a>
                            <a class="mb-3 btn btn-accent" href="register.php">Register</a>
                        </div> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div> <!--    Alter Warning End   -->
            <?php } ?>
        </section>
    </main>

    <!--    Include Footer   -->
    <?php include('assets/inc/footer.php') ?>