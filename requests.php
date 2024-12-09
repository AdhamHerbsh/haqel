    <!--    Include Header File     --> <?php include('assets/inc/header.php') ?> <!--    Include Loader File     --> <?php include('assets/inc/loader.php') ?> <!--    Include Navbar File     --> <?php include('assets/inc/nav.php') ?> <?php    // Get UserID from session    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;    // Check if the user ID is valid    if ($user_id === null | $user_type != "wholesaler") {        header("Location: 404.php"); // Redirect to 404 page if user is not logged in        exit();    }    
                                                                                                                                                                                                                                            ?> <main>
        <section id="" class=""> <?php if ($user_type == "wholesaler") { ?> <!-- Wholesaler Requests Start -->
                <div class="container-fluid requests">
                    <div class="container py-5">
                        <div class="section-title mb-5">
                            <h1>Requests of Special Orders</h1>
                            <h3 class="text-muted"> Approve Your Request To Get Deal</h3>
                        </div>
                        <div class="row g-4" style="min-height: 400px; max-height:800px; overflow-y: auto;">
                            <div class="col-12 col-md-4">
                                <div class="position-relative">
                                    <div class="order-number text-center p-2 border border-primary border-1 rounded-2 mb-3">
                                        <span><strong>Order Number:</strong> #<?= "2365488" ?></span>
                                    </div>
                                    <div class="order-details border border-gray border-1 rounded-2 p-3">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">PRODUCT NAME:</label>
                                                <p>Green Capsicum</p>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">PRODUCT CATEGORY:</label>
                                                <p>Vegetables</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label"> DESIRED PRICE:</label>
                                                <p> 14.00</p>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">QUANTITY:</label>
                                                <p>200</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">RE-RECEIVED DATE:</label>
                                                <p> 25/12/2024</p>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label class="form-label">SCHEDULE OPTION:</label>
                                                <p>Weekly</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">DESCRIPTION:</label>
                                            <p> The product should be in medium size and the color be good</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-accent">Reject</button>
                                                <span class="mx-2"></span>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contract-modal">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Wholesaler Requests End --> <!--    Upload Contart Modal Start      --> <!-- Modal Body --> <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                <div class="modal fade" id="contract-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">Upload Contract</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="post">
                            <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="" class="form-label">CHOOSE FILE:</label>
                                        <fieldset class="upload_dropZone text-center mb-3 p-4">
                                            <p class="small my-2">Drag and Drop File</p>
                                            <input id="contract_file" class="position-absolute invisible" type="file" multiple accept="image/*,.pdf" />
                                            <label id="upload_label" class="mb-3" for="contract_file">No File Chosen</label>
                                            <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>
                                        </fieldset>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">TERMS AND CONDITIONS:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="terms-conditions" required />
                                            <label class="form-check-label" for="terms-conditions">I Apply on all terms and conditions of website</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-accent" data-bs-dismiss="modal">Later</button>
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Optional: Place to the bottom of scripts -->
                <script>
                    const myModal = new bootstrap.Modal(document.getElementById("contract-modal"), options, );
                </script>
                <!--    Upload Contart Modal End    -->

            <?php } else { ?> <!--    Alter Warning Start  -->
                <div class="container py-5">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <div class="d-flex flex-column align-items-center"> <i class="bx bx-error bx-lg"></i>
                            <p><strong>Wrong Url <i class="bx bx-link"></i> You Must Login Or Register To Access This Page !</strong></p>
                            <a class="mb-3 btn btn-primary" href="login.php">Login</a>
                            <a class="mb-3 btn btn-accent" href="register.php">Register</a>
                        </div> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div> <!--    Alter Warning End   --> <?php } ?>
        </section>
    </main>
    <!--    Include Footer   -->
    <?php include('assets/inc/footer.php') ?>