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
    $stmt = $conn->prepare("SELECT * FROM special_orders WHERE SOSTATUS = 'unapproved'");

    // Bind user_id as an integer
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
                            <h1>Requests of Special Orders</h1>
                            <h3 class="text-muted"> Approve Your Request To Get Deal</h3>
                        </div>
                        <!--    Apprved Message Start  -->
                        <?php if (isset($_GET['action']) && $_GET['action'] === 'approved') { ?>
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <i class="bx bx-check-circle bx-sm"></i>
                                <strong>Request Approved Successfully</strong>
                                <span>Chat With Retailer</span>
                                <a href="chat.php" class="alert-link"><i class="bx bx-message bx-sm"></i></a>
                            </div>
                        <?php } ?>
                        <!--    Apprved Message Start  -->

                        <div class="row g-4" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                            <?php if ($result->num_rows > 0) { ?>
                                <?php foreach ($special_orders as $specialorder) : ?>
                                    <div class="col-12 col-md-4">
                                        <div class="position-relative">
                                            <div class="order-number text-center p-2 border border-primary border-1 rounded-2 mb-3">
                                                <span><strong>Special Order Number:</strong> #<?= $specialorder['SONUMBER'] ?></span>
                                            </div>
                                            <div class="order-details border border-gray border-1 rounded-2 p-3">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">PRODUCT NAME:</label>
                                                        <p><?= $specialorder['PNAME'] ?></p>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">PRODUCT CATEGORY:</label>
                                                        <p><?= $specialorder['PCATEGORY'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label"> DESIRED PRICE:</label>
                                                        <p><?= $specialorder['PPRICE'] ?></p>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">QUANTITY:</label>
                                                        <p><?= $specialorder['SOQUANTITY'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">RE-RECEIVED DATE:</label>
                                                        <p><?= $specialorder['SORECEIVEDDATE'] ?></p>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">SCHEDULE OPTION:</label>
                                                        <p><?= $specialorder['SOSCHEDULEOPTION'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">DESCRIPTION:</label>
                                                    <p><?= $specialorder['SODESCRIPTION'] ?></p>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-danger fw-bold" type="button">Reject</button>
                                                        <span class="mx-2"></span>
                                                        <a class="btn btn-primary fw-bold" type="button" href="#contract-modal" data-bs-toggle="modal" data-bs-target="#contract-modal">Approve</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--    Upload Contart Modal Start      -->
                                    <!--    Modal Body     -->
                                    <!--    if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard   -->
                                    <!-- Optimized Upload Contract Modal -->
                                    <div class="modal fade" id="contract-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">Upload Contract</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="assets/php/request.php" method="POST" enctype="multipart/form-data" id="uploadContractForm">
                                                    <input type="hidden" name="soid" value="<?= htmlspecialchars($specialorder['SOID']) ?>" />
                                                    <input type="hidden" name="sonumber" value="<?= htmlspecialchars($specialorder['SONUMBER']) ?>" />
                                                    <div class="modal-body overflow-hidden">
                                                        <div class="mb-3">
                                                            <label for="contract_file" class="form-label">Choose File:</label>
                                                            <fieldset class="upload_dropZone text-center mb-3 p-4">
                                                                <p class="small my-2">Drag and Drop File</p>
                                                                <input id="contract_file" class="position-absolute invisible" type="file" name="contract_file" required accept="image/*,.pdf" />
                                                                <label id="upload_label" class="mb-3" for="contract_file">No File Chosen</label>
                                                                <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>
                                                            </fieldset>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Terms and Conditions:</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="terms-conditions" required />
                                                                <label class="form-check-label" for="terms-conditions">I accept all terms and conditions of the website</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary fw-bold" type="reset" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary fw-bold" type="submit" name="approve-submit">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!--    Upload Contart Modal End    -->
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <!--    Alter Warning Start  -->
                                <div class="container py-5">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-data bx-lg"></i>
                                            <p><strong>No Data Found Enter At Later Time</strong></p>
                                            <a class="mb-3 btn btn-accent" href="add-product.php">Add Product</a>
                                            <a class="mb-3 btn btn-primary" href="predictive.php">See Predictive Product Prices</a>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                                <!--    Alter Warning End   -->
                            <?php } ?>
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