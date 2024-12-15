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

    <?php
    // Group items by food category
    $categories = [
        'Fruits' => [
            'Apple',
            'Banana',
            'Pomegranate',
            'Pear',
            'Strawberry',
            'Grape',
            'Mango',
            'Orange',
            'Kiwi',
            'Watermelon'
        ],
        'Vegetables' => [
            'Green Pepper',
            'Peas',
            'Eggplant',
            'Carrot',
            'Cucumber',
            'Green Chili',
            'Tomato',
            'Potato',
            'Onion',
            'Cilantro'
        ]
    ];
    ?>
    <?php if (isset($_GET['pid'])) { ?>
        <?php
        // Define price equations
        $equations = [
            'Apple' => [-0.0155, 0.0017, 0.0001, 37.8609],
            'Green Pepper' => [-0.1034, -0.0093, -0.0010, 213.2446],
            'Peas' => [-0.0553, -0.0073, -0.0008, 114.0728],
            'Watermelon' => [-0.0565, 0.0014, 0.0043, 117.4567],
            'Eggplant' => [0.1305, 0.0171, 0.0022, -259.7177],
            'Pomegranate' => [-0.1766, -0.0153, 0.0054, 365.2753],
            'Carrot' => [-0.1648, -0.0162, 0.0050, 336.6688],
            'Strawberry' => [-0.0220, 0.0026, 0.0019, 52.3071],
            'Cucumber' => [-0.0868, -0.0087, 0.0032, 179.4543],
            'Green Chili' => [-0.1269, -0.0099, -0.0013, 261.4601],
            'Cilantro' => [0.0853, 0.0038, 0.0028, -169.5646],
            'Banana' => [0.0626, 0.0025, -0.0054, -121.7326],
            'Tomato' => [0.0247, 0.0067, 0.0010, -44.7497],
            'Pear' => [0.0188, -0.0028, -0.0083, -31.2665],
            'Grape' => [-0.0322, -0.0066, -0.0025, 71.8295],
            'Mango' => [-0.0404, 0.0040, -0.0003, 88.9800],
            'Potato' => [-0.0968, -0.0086, -0.0034, 199.5570],
            'Onion' => [0.0818, 0.0060, -0.0058, -161.7872],
            'Orange' => [0.1314, 0.0083, 0.0033, -259.4723],
            'Kiwi' => [0.0797, 0.0012, -0.0048, -152.1228]
        ];

        // Get product ID from URL
        $productID = $_GET['pid'] ?? '';

        // Validate product ID
        if (!array_key_exists($productID, $equations)) {
            die("Invalid Product ID.");
        }

        // Define function to calculate price
        function calculatePrice($coefficients, $year, $month, $day)
        {
            [$a, $b, $c, $d] = $coefficients;
            return ($a * $year) + ($b * $month) + ($c * $day) + $d;
        }

        // Generate table for the next 10 days
        $today = new DateTime();
        $priceTable = [];

        for ($i = 0; $i < 10; $i++) {
            $date = clone $today;
            $date->modify("+$i days");
            $year = (int) $date->format('Y');
            $month = (int) $date->format('m');
            $day = (int) $date->format('d');

            $price = calculatePrice($equations[$productID], $year, $month, $day);
            $percentageChange = $i === 0 ? 0 : (($price - $priceTable[$i - 1]['Price']) / $priceTable[$i - 1]['Price']) * 100;

            $priceTable[] = [
                'Date' => $date->format('Y-m-d'),
                'Price' => number_format($price, 2),
                'Percentage' => number_format($percentageChange, 2) . '%'
            ];
        }

        // Display the table
        ?>
        <!--    Predictive Section Start     -->
        <section id="predictive" class="predictive">
            <div class="container-fluid">
                <div class="container py-5">
                    <div class="section-title mb-3">
                        <h1>Our Providers</h1>
                        <h3 class="text-muted">See Best Wholesalers On Website</h3>
                    </div>
                    <div class="prodcut">
                        <h2><?= htmlspecialchars($productID) ?></h2>
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
                                <?php $i = 0;
                                foreach ($priceTable as $row): ?>
                                    <tr>
                                        <td><?= $i += 1; ?></td>
                                        <td><?= $row['Date'] ?></td>
                                        <td><?= $row['Price'] ?> <small>SAR</small></td>
                                        <td><?= $row['Percentage'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
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
                    <div class="vegetables">
                        <h2>Vegetables</h2>
                        <div class="row g-4">
                            <?php foreach ($categories['Vegetables'] as $category) : ?>
                                <div class="col-12 col-md-4 p-4">
                                    <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                        <h2><?= htmlspecialchars($category) ?></h2>
                                        <div class="product-img">
                                            <img src="assets/img/vegetables/<?= strtolower(str_replace(' ', '-', $category)) ?>.png"
                                                class="img-fluid w-100 rounded-top"
                                                alt="<?= htmlspecialchars($category) ?>">
                                        </div>
                                        <div class="p-4">
                                            <div class="d-md-flex justify-content-center">
                                                <a href="predictive.php?pid=<?= urlencode($category) ?>"
                                                    class="btn btn-secondary rounded-pill">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="fruits">
                        <h2>Fruits</h2>
                        <div class="row g-4">
                            <?php foreach ($categories['Fruits'] as $category) : ?>
                                <div class="col-12 col-md-4 p-4">
                                    <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                        <h2><?= htmlspecialchars($category) ?></h2>
                                        <div class="product-img">
                                            <img src="assets/img/fruits/<?= strtolower(str_replace(' ', '-', $category)) ?>.png"
                                                class="img-fluid w-100 rounded-top"
                                                alt="<?= htmlspecialchars($category) ?>">
                                        </div>
                                        <div class="p-4">
                                            <div class="d-md-flex justify-content-center">
                                                <a href="predictive.php?pid=<?= urlencode($category) ?>"
                                                    class="btn btn-secondary rounded-pill">More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
        </section>
        <!--    Predictive Products End     -->
    <?php } ?>




</main>

<!--    Include Footer   -->

<?php include('assets/inc/footer.php') ?>