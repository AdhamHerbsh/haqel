<?php


// Get UserID from session
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;

?>
<!-- Navbar start -->
<div class="container-fluid fixed-top shadow">
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php" class="navbar-brand">
                <img class="img-fluid" src="assets/img/logo/haqel-logo-thumbnail.png" alt="image not found">
            </a>
            <button class="navbar-toggler py-1 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <i class='bx bx-menu'></i>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <?php if ($user_type == null) { ?>
                        <a href="#about" class="nav-item nav-link">About</a>
                        <a href="#categories" class="nav-item nav-link">Categories</a>
                        <a href="#services" class="nav-item nav-link">Services</a>
                        <a href="#contact" class="nav-item nav-link">Contact</a>
                    <?php } else { ?>
                        <?php if ($user_type == "wholesaler") { ?>
                            <a href="predictive.php" class="nav-item nav-link">Predictive</a>
                            <a href="predictive.php" class="nav-item nav-link">My Products</a>
                            <a href="predictive.php" class="nav-item nav-link">Requests</a>
                            
                            <?php } elseif ($user_type == "retailer") { ?>
                            <a href="predictive.php" class="nav-item nav-link">Predictive</a>
                            <a href="predictive.php" class="nav-item nav-link">My Orders</a>
                            <a href="predictive.php" class="nav-item nav-link">Special Order</a>

                        <?php } else { ?>
                            <a href="users-list.php" class="nav-item nav-link">Users</a>

                    <?php }
                    } ?>

                </div>
                <?php if ($user_type == null) { ?>
                    <!--    Public Navbar Start  -->
                    <div class="d-flex m-3 me-0">
                        <a href="register.php" class="btn btn-primary">
                            SignUp
                        </a>
                        <span class="m-1"></span>
                        <a href="login.php" class="btn btn-primary">
                            SignIn
                        </a>
                    </div>
                    <!--    Public Navbar End  -->
                <?php } else { ?>

                    <!--    User Navbar Start  -->
                    <div class="d-flex m-3 me-0">
                        <?php if ($user_type == "wholesaler") { ?>
                            <!--    Wholesaler Navbar Start  -->
                            <a href="requests.php" class="position-relative me-4 my-auto text-black">
                                <i class="bx bx-message-detail bx-md"></i>
                            </a>
                            <!--    Wholesaler Navbar End  -->

                        <?php } elseif ($user_type == "retailer") { ?>
                            <!--    Retailer Navbar Start  -->
                            <a href="shop.php" class="position-relative me-4 my-auto text-black">
                                <i class="bx bx-basket bx-md"></i>
                            </a>
                            <!--    Retailer Navbar End  -->

                        <?php } else { ?>
                        <?php } ?>
                        <!--    Account Navbar Start  -->
                        <a href="user-profile.php" class="my-auto text-black">
                            <i class="bx bx-user-circle bx-md"></i>
                        </a>
                        <!--    Account Navbar End  -->
                        <!--    User Navbar End  -->
                    <?php } ?>
                    </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->