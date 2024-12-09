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
?>
<main>

    <?php if (isset($_GET['pid'])) { ?>
        <!--    Predictive Section Start     -->
        <section id="predictive" class="predictive">
            <div class="container-fluid">
                <div class="container py-5">
                    <div class="section-title mb-3">
                        <h1>Our Providers</h1>
                        <h3 class="text-muted">See Best Wholesalers On Website</h3>
                    </div>
                    <div class="prodcut">
                        <h2>Chinese Cabbage</h2>
                    </div>
                    <hr>
                    <div class="table-responsive my-5 rounded-2 shadow" style="max-height: 60vh; overflow-y:auto;">
                        <table class="table table-bordered text-center">
                            <thead class="table-header">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>1/1/2025</td>
                                    <td>10.50 <small>SAR</small></td>
                                    <td>30%</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2/1/2025</td>
                                    <td>10.40 <small>SAR</small></td>
                                    <td>-10%</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>3/1/2025</td>
                                    <td>11.50 <small>SAR</small></td>
                                    <td>30%</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>4/1/2025</td>
                                    <td>10.30 <small>SAR</small></td>
                                    <td>-60%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!--    Predictive Section End     -->
    <?php } else { ?>
        <!--    Predictive Products Start     -->
        <section>
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title">
                        <h1>Predictive Price</h1>
                        <h3 class="text-muted">Know More About Predictive Pricing Products</h3>
                    </div>
                    <?php
                    // Prepare SQL to fetch user and account data
                    $stmt = $conn->prepare("SELECT * FROM products WHERE PCATEGORY = 'vegetables'");

                    // Bind user_id as an integer
                    $stmt->execute();

                    // Fetch data as an associative array
                    $result = $stmt->get_result();
                    $vegetables = $result->fetch_all(MYSQLI_ASSOC);

                    ?>
                    <div class="vegetables">
                        <h2>Vegetables</h2>
                        <div class="row g-4">
                            <?php if ($result->num_rows > 0) { ?>
                                <?php foreach ($vegetables as $vegetable) : ?>
                                    <div class="col-12 col-md-4 p-4">
                                        <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                            <h2><?= ucfirst($vegetable['PNAME']) ?></h2>
                                            <div class="product-img">
                                                <img src="<?= $vegetable['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="<?= ucfirst($vegetable['PNAME']) ?>">
                                            </div>
                                            <div class="p-4">
                                                <div class="d-md-flex justify-content-center">
                                                    <a href="predictive.php?pid=<?= $vegetable['PID'] ?>" class="btn btn-secondary rounded-pill">More Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <!--    Alter Warning Start  -->
                                <div class="container py-5">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-data bx-lg"></i>
                                            <p><strong>No Data Found Enter At Late Time</strong></p>
                                            <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                                <!--    Alter Warning End   -->

                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    // Prepare SQL to fetch user and account data
                    $stmt = $conn->prepare("SELECT * FROM products WHERE PCATEGORY = 'fruits'");

                    // Bind user_id as an integer
                    $stmt->execute();

                    // Fetch data as an associative array
                    $result = $stmt->get_result();
                    $fruits = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <div class="fruits">
                        <h2>Fruits</h2>
                        <div class="row g-4">
                            <?php if ($result->num_rows > 0) { ?>
                                <?php foreach ($fruits as $fruit) : ?>
                                    <div class="col-12 col-md-4 p-4">
                                        <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                            <h2><?= ucfirst($fruit['PNAME']) ?></h2>
                                            <div class="product-img">
                                                <img src="<?= $fruit['PIMAGE'] ?>" class="img-fluid w-100 rounded-top" alt="<?= ucfirst($fruit['PNAME']) ?>">
                                            </div>
                                            <div class="p-4">
                                                <div class="d-md-flex justify-content-center">
                                                    <a href="predictive.php?pid=<?= $fruit['PID'] ?>" class="btn btn-secondary rounded-pill">More Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <!--    Alter Warning Start  -->
                                <div class="container py-5">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-data bx-lg"></i>
                                            <p><strong>No Data Found Enter At Late Time</strong></p>
                                            <a class="mb-3 btn btn-primary" href="special-order.php">Special Order</a>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                                <!--    Alter Warning End   -->

                            <?php } ?>
                        </div>
                    </div>
                </div>
        </section>
        <!--    Predictive Products End     -->
        <?php
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    <?php } ?>




</main>

<!--    Include Footer   -->

<?php include('assets/inc/footer.php') ?>