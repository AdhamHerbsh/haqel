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
        $itemID = $_GET['pid'] ?? '';

        // Validate product ID
        if (!array_key_exists($itemID, $equations)) {
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

            $price = calculatePrice($equations[$itemID], $year, $month, $day);
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
                        <h2><?= htmlspecialchars($itemID) ?></h2>
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
                    <div class="tabs-class">
                        <div class="row g-4">
                            <!-- Search bar -->
                            <div class="col-12 col-md-6 position-relative mx-auto">
                                <input class="form-control border-2 border-gray py-3 rounded-pill" type="text" placeholder="Write what you want?">
                                <button type="submit" class="btn btn-secondary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0%;">Submit Now</button>
                            </div>
                            <!-- Tabs -->
                            <div class="col-12 col-md-6 text-end">
                                <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                    <li class="nav-item">
                                        <a class="d-flex p-2 m-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-all">
                                            <span class="text-dark">All Products</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="d-flex p-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-fruits">
                                            <span class="text-dark">Fruits</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="d-flex p-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-vegetables">
                                            <span class="text-dark">Vegetables</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div id="tab-all" class="tab-pane fade show p-0 active">
                                    <div class="row g-4">
                                    <?php foreach ($categories as $category => $items) : ?>
                                        <div class="col-12 col mb-3">
                                            <h2><?= $category ?></h2>
                                        </div>
                                        <?php foreach ($items as $item) : ?>
                                                <div class="col-12 col-md-4 p-4">
                                                    <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                                        <h2><?= htmlspecialchars($item) ?></h2>
                                                        <div class="product-img">
                                                            <img src="assets/img/<?= ($category ===  'Fruits' )? 'fruits' : 'vegetables' ?>/<?= strtolower(str_replace(' ', '-', $item)) ?>.png" class="img-fluid w-100 rounded-top">
                                                        </div>
                                                        <div class="p-4">
                                                            <div class="d-md-flex justify-content-center">
                                                                <a href="predictive.php?pid=<?= urlencode($item) ?>" class="btn btn-secondary rounded-pill">More Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div id="tab-fruits" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                    <?php foreach ($categories['Fruits'] as $fruits) : ?>
                                                <div class="col-12 col-md-4 p-4">
                                                    <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                                        <h2><?= htmlspecialchars($fruits) ?></h2>
                                                        <div class="product-img">
                                                            <img src="assets/img/fruits/<?= strtolower(str_replace(' ', '-', $fruits)) ?>.png" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($fruits) ?>">
                                                        </div>
                                                        <div class="p-4">
                                                            <div class="d-md-flex justify-content-center">
                                                                <a href="predictive.php?pid=<?= urlencode($fruits) ?>" class="btn btn-secondary rounded-pill">More Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                    </div>
                                </div>
                                <div id="tab-vegetables" class="tab-pane fade show p-0">
                                    <div class="row g-4">
                                            <?php foreach ($categories['Vegetables'] as $vegetables) : ?>
                                                <div class="col-12 col-md-4 p-4">
                                                    <div class="text-center border border-white-50 rounded-2 position-relative product-item">
                                                        <h2><?= htmlspecialchars($vegetables) ?></h2>
                                                        <div class="product-img">
                                                            <img src="assets/img/vegetables/<?= strtolower(str_replace(' ', '-', $vegetables)) ?>.png" class="img-fluid w-100 rounded-top" alt="<?= htmlspecialchars($vegetables) ?>">
                                                        </div>
                                                        <div class="p-4">
                                                            <div class="d-md-flex justify-content-center">
                                                                <a href="predictive.php?pid=<?= urlencode($vegetables) ?>" class="btn btn-secondary rounded-pill">More Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </section>
        <!--    Predictive Products End     -->
    <?php } ?>




</main>

<!--    Include Footer   -->

<?php include('assets/inc/footer.php') ?>