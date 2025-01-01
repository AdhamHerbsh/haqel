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
if ($user_id === null || $user_type != "wholesaler") {
    header("Location: 404.php"); // Redirect to 404 page if user is not logged in
    exit();
}

// Prepare SQL to fetch user and account data
$stmt = $conn->prepare("SELECT * FROM products WHERE USER_ID = ?");
$stmt->bind_param("i", $user_id);

// Bind user_id as an integer
$stmt->execute();

// Fetch data as an associative array
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<main>

    <!--    Add Product Section Start     -->
    <section id="" section="">
        <div class="container-fluid py-5">
            <div class="container">
                <div class="section-title">
                    <h1>Add Product</h1>
                    <h3 class="text-muted">Add The Details Of Product</h3>
                </div>
                <?php
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == "success") {
                ?>
                        <div class="alert alert-success" role="alert">
                            <i class='bx bx-check bx-md'></i>
                            <strong>Product Added Successfully</strong>
                        </div>
                    <?php
                    } elseif ($_GET['action'] == "edited") {
                    ?>
                        <div class="alert alert-secondary" role="alert">
                            <i class="bx bx-like bx-md"></i>
                            <strong>Product Edited Successfully</strong>
                        </div>
                    <?php
                    } elseif ($_GET['action'] == "deleted") {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="bx bx-trash bx-md"></i>
                            <strong>Product Deleted Successfully</strong>
                        </div>
                <?php
                    }
                }
                ?>


                <!-- Add Produt Quick button -->
                <a href="#product" class="btn btn-primary border-3 border-primary rounded-circle add-product"
                    data-bs-toggle="modal" role="button"><i class="bx bx-plus bx-sm"></i></a>


                <!--   Add Product Modal Start -->
                <div class="modal fade" id="product" aria-hidden="true" aria-labelledby="productLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productLabel">
                                    Add Product <i class="bx bx-credit-card-alt"></i>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                                <form class="p-4 border border-1 rounded-2" action="assets/php/product.php"
                                    method="POST" enctype="multipart/form-data">
                                    <div class="my-3">
                                        <h5> Add Product Details</h5>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <di class="mb-3">
                                                <label for="pcategory" class="form-label">CATEGORY:</label>
                                                <select class="searchable-select" name="pcategory" id="pcategory" required>
                                                    <option disabled selected value>Select Category:</option>
                                                    <option value="fruits">Fruits</option>
                                                    <option value="vegetables">Vegetables</option>
                                                </select>
                                            </di>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="pname" class="form-label">PRODUCT:</label>
                                                <select class="searchable-select" name="pname" id="pname" required>
                                                    <option disabled selected value>Select Product</option>
                                                    <optgroup label="Fruits">
                                                        <option value="apple">Apple</option>
                                                        <option value="mango">Mango</option>
                                                        <option value="banana">Banana</option>
                                                        <option value="orange">Orange</option>
                                                        <option value="grape">Grape</option>
                                                        <option value="watermelon">Watermelon</option>
                                                        <option value="pear">Pear</option>
                                                        <option value="strawberry">Strawberry</option>
                                                        <option value="pomegranate">Pomegranate</option>
                                                        <option value="kiwi">Kiwi</option>
                                                    </optgroup>
                                                    <optgroup label="Vegetables">
                                                        <option value="green-papper">Green Pepper</option>
                                                        <option value="cucumber">Cucumber</option>
                                                        <option value="onion">Onion</option>
                                                        <option value="cilantro">Cilantro</option>
                                                        <option value="green-chili">Green Chili</option>
                                                        <option value="peas">Peas</option>
                                                        <option value="eggplant">Eggplant</option>
                                                        <option value="carrot">Carrot</option>
                                                        <option value="potato">Potato</option>
                                                        <option value="tomato">Tomato</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="pcountry" class="form-label">COUNTRY:</label>
                                                <select class="searchable-select" name="pcountry" id="pcountry" required>
                                                    <option disabled selected value>Select Country:</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="Brunei">Brunei</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cabo Verde">Cabo Verde</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Eswatini">Eswatini</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia">Micronesia</option>
                                                    <option value="Moldova">Moldova</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="North Korea">North Korea</option>
                                                    <option value="North Macedonia">North Macedonia</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestine">Palestine</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Korea">South Korea</option>
                                                    <option value="South Sudan">South Sudan</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syria">Syria</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania">Tanzania</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-Leste">Timor-Leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Vatican City">Vatican City</option>
                                                    <option value="Venezuela">Venezuela</option>
                                                    <option value="Vietnam">Vietnam</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="pprice" class="form-label">PRICE:</label>
                                                <input type="number" class="form-control" name="pprice" id="pprice" placeholder="00" min="1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label for="pkeywords" class="form-label">KEYWORDS:</label>
                                                <input type="text" class="form-control" name="pkeywords"
                                                    id="pkeywords" placeholder="Write Keywords About Product" />
                                                <div id="highlighted-keywords" class="mt-3"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">QUANTITY:</label>
                                                <div class="mb-3">
                                                    <div
                                                        class="input-group w-50 quantity bg-white rounded-pill py-3">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border qty-btn"
                                                                type="button">
                                                                <i class="bx bx-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input id="qty-input" type="number" class="form-control form-control-sm text-center border-0" name="quantity" min="0" value="1">                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border qty-btn"
                                                                type="button">
                                                                <i class="bx bx-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="pdescription" class="form-label">DESCRIPTION:</label>
                                                <textarea class="form-control" name="pdescription" id="pdescription"
                                                    rows="3" placeholder="Write Product Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-accent fw-bold shadow-sm" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                            <span class="mx-2"></span>
                                            <button type="submit" name="create" id="create-btn" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--   Add Product Modal End -->

            </div>
        </div>
    </section>
    <!--    Add Product Section End     -->

    <!--    My Products Section Start     -->
    <section>
        <div class="container-fluid product">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <?php foreach ($products as $product) : ?>
                                <div class="col-12 col-md-4">
                                    <div class="border border-gray rounded-2 position-relative product-item">
                                        <div class="product-img">
                                            <img src="<?= $product['PIMAGE'] ?>" class="img-fluid w-100 rounded-top"
                                                alt="">
                                        </div>
                                        <div class="p-4">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p><?= ucfirst($product['PNAME']) ?></p>
                                                <div class="px-3 py-1 rounded <?= ($product['PSTATUS'] === 'available') ? "bg-primary-50" : "bg-gray text-white" ?>" ><span><?= ucfirst($product['PSTATUS']) ?></span></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="text-dark fs-5 fw-bold"><small>SAR</small>
                                                        <?= $product['PPRICE'] ?></p>
                                                    <p class="mb-0"><?= ucfirst($product['PCATEGORY']) ?></p>
                                                    <p class="mb-0"><?= $product['PCOUNTRY'] ?></p>
                                                </div>
                                                <div
                                                    class="col-6 d-flex justify-content-end align-items-center product-btn">
                                                    <a href="update-product.php?pid=<?= $product['PID'] ?>"
                                                        class="btn btn-secondary rounded-circle"><i
                                                            class="bx bx-edit bx-sm"></i></a>
                                                    <div class="mx-2"></div>
                                                    <a href="assets/php/product.php?pid=<?= $product['PID'] ?>&action=delete"
                                                        class="btn btn-danger rounded-circle"><i
                                                            class="bx bx-trash bx-sm"></i></a>
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
    <!--    My Products Section End     -->

</main>

<!--    Include Footer   -->

<?php include('assets/inc/footer.php') ?>