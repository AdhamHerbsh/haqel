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
        
    } else {
        // Prepare SQL to fetch user and account data
        $stmt = $conn->prepare("
        SELECT 
            u.USERNAME, 
            u.FNAME, 
            u.LNAME, 
            u.PHONE, 
            u.USER_TYPE, 
            a.business_name, 
            a.business_email, 
            a.business_type, 
            a.coverage_areas, 
            a.business_segment, 
            a.commercial_register_file
        FROM 
            users u
        LEFT JOIN 
            account a 
        ON 
            u.ID = a.user_id
        WHERE 
            u.ID = ?
    ");

        $stmt->bind_param("i", $user_id); // Bind user_id as an integer
        $stmt->execute();
        $stmt->store_result();

        // Check if data exists
        if ($stmt->num_rows > 0) {
            // Bind the result
            $stmt->bind_result(
                $username,
                $fname,
                $lname,
                $phone,
                $user_type,
                $business_name,
                $business_email,
                $business_type,
                $coverage_areas,
                $business_segment,
                $commercial_register_file
            );
            $stmt->fetch();
        } else {
            echo "<script>alert('User profile not found. Redirecting to 404 page.');</script>";
            header("Location: 404.php");
            exit();
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>



    <main>
        <!--    User Profile Section Start     -->
        <section id="" section="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title">
                        <h1><?= ucfirst($user_type) ?></h1>
                        <h3 class="text-muted">Profile</h3>
                    </div>
                    <form class="" action="assets/php/profile.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input type="hidden" class="form-control" name="user_type" id="user_type" value="<?= $user_type ?>" />
                                <input type="hidden" class="form-control" name="old_comm_file" id="old_comm_file" value="<?= $commercial_register_file ?>" />
                                <div class="mb-3">
                                    <label for="fname" class="form-label">FIRST NAME:</label>
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter Your First Name" value="<?= $fname ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">LAST NAME:</label>
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Your Last Name" value="<?= $lname ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">

                                <div class="mb-3">
                                    <label for="phone" class="form-label">PHONE:</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter Your Phone Number" value="<?= $phone ?>" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="mb-3">
                                    <label for="username" class="form-label">EMAIL:</label>
                                    <input type="email" class="form-control" name="username" id="username" placeholder="Enter Your Email Address" value="<?= $username ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="bname" class="form-label">BUSNIESS NAME:</label>
                                <input type="text" class="form-control" name="bname" id="bname" placeholder="Enter Name" value="<?= $business_name ?>" />
                            </div>
                            <?php if (isset($business_type)) { ?>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label">BUSNIESS TYPE:</label>
                                    <div class="my-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="btype" id="radio-farm" value="farm" <?= ($business_type == "farm")  ? "checked" : "" ?> />
                                            <label class="form-check-label" for="radio-farm">Farm</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="btype" id="radio-provider" value="provider" <?= ($business_type == "provider")  ? "checked" : "" ?> />
                                            <label class="form-check-label" for="radio-provider">Provider</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="cov_area" class="form-label">COVERAGE AREAS:</label>
                                    <input type="text" class="form-control" name="cov_area" id="cov_area" placeholder="Enter Coverage Areas" value="<?= $coverage_areas ?>" />
                                </div>
                            <?php } elseif (isset($business_email)) { ?>
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="bemail" class="form-label">BUSNIESS EMAIL:</label>
                                    <input type="text" class="form-control" name="bemail" id="bemail" placeholder="Enter Email Address" value="<?= $business_email ?>" />
                                </div>
                                <div class="mb-3">
                                    <label for="business_segment" class="form-label">BUSNIESS SEGMENT:</label>
                                    <select class="form-select form-select-lg" name="business_segment" id="business_segment">
                                        <option selected>Select one</option>
                                        <option value="local" <?= ($business_segment == "local")  ? "selected" : "" ?>>Local Grocery Store</option>
                                        <option value="supermarket" <?= ($business_segment == "supermarket")  ? "selected" : "" ?>>Supermarket</option>
                                        <option value="hypermarket" <?= ($business_segment == "hypermarket")  ? "selected" : "" ?>>Hypermarket</option>
                                        <option value="farmer" <?= ($business_segment == "farmer")  ? "selected" : "" ?>>Farmer Market</option>
                                        <option value="online" <?= ($business_segment == "online")  ? "selected" : "" ?>>Online Grocery Retailer</option>
                                        <option value="juice" <?= ($business_segment == "juice")  ? "selected" : "" ?>>Juice Bar</option>
                                        <option value="smoothie" <?= ($business_segment == "smoothie")  ? "selected" : "" ?>>Smoothie Shop</option>
                                        <option value="caffe" <?= ($business_segment == "caffe")  ? "selected" : "" ?>>Caffe</option>
                                        <option value="restaurant" <?= ($business_segment == "restaurant")  ? "selected" : "" ?>>Restaurant</option>
                                        <option value="exporter" <?= ($business_segment == "exporter")  ? "selected" : "" ?>>Exporter</option>
                                        <option value="personal" <?= ($business_segment == "personal")  ? "selected" : "" ?>>Personal</option>
                                    </select>
                                </div>
                        </div>
                    <?php } elseif (isset($business_type)) { ?>

                    <?php } else {
                            } ?>

                    <div class="mb-3">
                        <label for="" class="form-label">UPLOAD COMMERCIAL REGISTER FILE:</label>
                        <input type="file" class="form-control" name="comm_file" id="comm_file" placeholder="No File Chosen" />
                    </div>
                    <div class="container">
                        <div class="float-end mb-3">
                            <button type="reset" name="cancel" id="cancel" class="btn btn-accent"> Cancel </button>
                            <button type="submit" name="save" id="save" class="btn btn-primary"> Save </button>
                        </div>
                        <a class="col-12 btn btn-accent" href="assets/php/logout.php">Logout <i class="bx bx-log-out"></i></a>
                    </div>
                    </form>
                </div>
            </div>
        </section>
        <!--    User Profile Section End     -->

    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>