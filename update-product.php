    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

    <main>
        <?php

        // Get UserID from session
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Check if the user ID is valid
        if ($user_id === null | $user_type != "wholesaler") {
            header("Location: 404.php"); // Redirect to 404 page if user is not logged in
            exit();
        }

        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            // Prepare SQL to fetch product data
            $stmt = $conn->prepare("SELECT PNAME, PCATEGORY, PCOUNTRY, PPRICE, PKEYWORDS, PQUANTITY, PDESCRIPTION, PIMAGE, USER_ID FROM products WHERE PID = ?");

            $stmt->bind_param("i", $pid); // Bind user_id as an integer
            $stmt->execute();
            $stmt->store_result();

            // Check if data exists
            if ($stmt->num_rows > 0) {
                // Bind the result
                $stmt->bind_result($pname, $pcategory, $pcountry, $pprice, $pkeywords, $pquantity, $pdescription, $pimage, $user_id);
                $stmt->fetch();
            } else {
                echo "<script>alert('Product Data Didn't Found!');</script>";
                header("Location: 404.php");
                exit();
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }


        ?>
        <!--    Update Product Section Start     -->
        <section id="" section="">
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="section-title">
                        <h1>Edit Product</h1>
                        <h3 class="text-muted">Edit The Details Of Product</h3>
                    </div>
                    <div class="my-3">
                        <h5> Edit Product Details</h5>
                    </div>
                    <form class="p-4 border border-1 rounded-2" action="assets/php/product.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="pid" value="<?= $pid ?>" />
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pcategory" class="form-label">CATEGORY:</label>
                                    <select class="searchable-select" name="pcategory" id="pcategory" required>
                                        <option disabled selected value>Select Category:</option>
                                        <option value="fruits" <?= ($pcategory == "fruits") ? "selected" : "" ?>>Fruits</option>
                                        <option value="vegetables" <?= ($pcategory == "vegetables") ? "selected" : "" ?>>Vegetables</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pname" class="form-label">PRODUCT:</label>
                                    <select class="searchable-select" name="pname" id="pname" required>
                                        <optgroup label="Fruits">
                                            <option value="apple" <?= ($pname == "apple") ? "selected" : "" ?>>Apple</option>
                                            <option value="mango" <?= ($pname == "mango") ? "selected" : "" ?>>Mango</option>
                                            <option value="banana" <?= ($pname == "banana") ? "selected" : "" ?>>Banana</option>
                                            <option value="orange" <?= ($pname == "orange") ? "selected" : "" ?>>Orange</option>
                                            <option value="grape" <?= ($pname == "grape") ? "selected" : "" ?>>Grape</option>
                                            <option value="watermelon" <?= ($pname == "watermelon") ? "selected" : "" ?>>Watermelon</option>
                                            <option value="pear" <?= ($pname == "pear") ? "selected" : "" ?>>Pear</option>
                                            <option value="strawberry" <?= ($pname == "strawberry") ? "selected" : "" ?>>Strawberry</option>
                                            <option value="pomegranate" <?= ($pname == "pomegranate") ? "selected" : "" ?>>Pomegranate</option>
                                            <option value="kiwi" <?= ($pname == "kiwi") ? "selected" : "" ?>>Kiwi</option>
                                        </optgroup>
                                        <optgroup label="Vegetables">
                                            <option value="green-papper" <?= ($pname == "green") ? "selected" : "" ?>>Green Pepper</option>
                                            <option value="cucumber" <?= ($pname == "cucumber") ? "selected" : "" ?>>Cucumber</option>
                                            <option value="onion" <?= ($pname == "onion") ? "selected" : "" ?>>Onion</option>
                                            <option value="cilantro" <?= ($pname == "cilantro") ? "selected" : "" ?>>Cilantro</option>
                                            <option value="green-chili" <?= ($pname == "green") ? "selected" : "" ?>>Green Chili</option>
                                            <option value="peas" <?= ($pname == "peas") ? "selected" : "" ?>>Peas</option>
                                            <option value="eggplant" <?= ($pname == "eggplant") ? "selected" : "" ?>>Eggplant</option>
                                            <option value="carrot" <?= ($pname == "carrot") ? "selected" : "" ?>>Carrot</option>
                                            <option value="potato" <?= ($pname == "potato") ? "selected" : "" ?>>Potato</option>
                                            <option value="tomato" <?= ($pname == "tomato") ? "selected" : "" ?>>Tomato</option>
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
                                        <option value="Afghanistan" <?= ($pcountry == "Afghanistan") ? "selected" : "" ?>>Afghanistan</option>
                                        <option value="Albania" <?= ($pcountry == "Albania") ? "selected" : "" ?>>Albania</option>
                                        <option value="Algeria" <?= ($pcountry == "Algeria") ? "selected" : "" ?>>Algeria</option>
                                        <option value="Andorra" <?= ($pcountry == "Andorra") ? "selected" : "" ?>>Andorra</option>
                                        <option value="Angola" <?= ($pcountry == "Angola") ? "selected" : "" ?>>Angola</option>
                                        <option value="Antigua and Barbuda" <?= ($pcountry == "Antigua and Barbuda") ? "selected" : "" ?>>Antigua and Barbuda</option>
                                        <option value="Argentina" <?= ($pcountry == "Argentina") ? "selected" : "" ?>>Argentina</option>
                                        <option value="Armenia" <?= ($pcountry == "Armenia") ? "selected" : "" ?>>Armenia</option>
                                        <option value="Australia" <?= ($pcountry == "Australia") ? "selected" : "" ?>>Australia</option>
                                        <option value="Austria" <?= ($pcountry == "Austria") ? "selected" : "" ?>>Austria</option>
                                        <option value="Azerbaijan" <?= ($pcountry == "Azerbaijan") ? "selected" : "" ?>>Azerbaijan</option>
                                        <option value="Bahamas" <?= ($pcountry == "Bahamas") ? "selected" : "" ?>>Bahamas</option>
                                        <option value="Bahrain" <?= ($pcountry == "Bahrain") ? "selected" : "" ?>>Bahrain</option>
                                        <option value="Bangladesh" <?= ($pcountry == "Bangladesh") ? "selected" : "" ?>>Bangladesh</option>
                                        <option value="Barbados" <?= ($pcountry == "Barbados") ? "selected" : "" ?>>Barbados</option>
                                        <option value="Belarus" <?= ($pcountry == "Belarus") ? "selected" : "" ?>>Belarus</option>
                                        <option value="Belgium" <?= ($pcountry == "Belgium") ? "selected" : "" ?>>Belgium</option>
                                        <option value="Belize" <?= ($pcountry == "Belize") ? "selected" : "" ?>>Belize</option>
                                        <option value="Benin" <?= ($pcountry == "Benin") ? "selected" : "" ?>>Benin</option>
                                        <option value="Bhutan" <?= ($pcountry == "Bhutan") ? "selected" : "" ?>>Bhutan</option>
                                        <option value="Bolivia" <?= ($pcountry == "Bolivia") ? "selected" : "" ?>>Bolivia</option>
                                        <option value="Bosnia and Herzegovina" <?= ($pcountry == "Bosnia and Herzegovina") ? "selected" : "" ?>>Bosnia and Herzegovina</option>
                                        <option value="Botswana" <?= ($pcountry == "Botswana") ? "selected" : "" ?>>Botswana</option>
                                        <option value="Brazil" <?= ($pcountry == "Brazil") ? "selected" : "" ?>>Brazil</option>
                                        <option value="Brunei" <?= ($pcountry == "Brunei") ? "selected" : "" ?>>Brunei</option>
                                        <option value="Bulgaria" <?= ($pcountry == "Bulgaria") ? "selected" : "" ?>>Bulgaria</option>
                                        <option value="Burkina Faso" <?= ($pcountry == "Burkina Faso") ? "selected" : "" ?>>Burkina Faso</option>
                                        <option value="Burundi" <?= ($pcountry == "Burundi") ? "selected" : "" ?>>Burundi</option>
                                        <option value="Cabo Verde" <?= ($pcountry == "Cabo") ? "selected" : "" ?>>Cabo Verde</option>
                                        <option value="Cambodia" <?= ($pcountry == "Cambodia") ? "selected" : "" ?>>Cambodia</option>
                                        <option value="Cameroon" <?= ($pcountry == "Cameroon") ? "selected" : "" ?>>Cameroon</option>
                                        <option value="Canada" <?= ($pcountry == "Canada") ? "selected" : "" ?>>Canada</option>
                                        <option value="Central African Republic" <?= ($pcountry == "Central African Republic") ? "selected" : "" ?>>Central African Republic</option>
                                        <option value="Chad" <?= ($pcountry == "Chad") ? "selected" : "" ?>>Chad</option>
                                        <option value="Chile" <?= ($pcountry == "Chile") ? "selected" : "" ?>>Chile</option>
                                        <option value="China" <?= ($pcountry == "China") ? "selected" : "" ?>>China</option>
                                        <option value="Colombia" <?= ($pcountry == "Colombia") ? "selected" : "" ?>>Colombia</option>
                                        <option value="Comoros" <?= ($pcountry == "Comoros") ? "selected" : "" ?>>Comoros</option>
                                        <option value="Congo (Congo-Brazzaville)"  <?= ($pcountry == "Congo (Congo-Brazzaville)") ? "selected" : "" ?>>Congo (Congo-Brazzaville)</option>
                                        <option value="Costa  <?= ($pcountry == "Costa") ? "selected" : "" ?>Rica">Costa Rica</option>
                                        <option value="Croatia" <?= ($pcountry == "Croatia") ? "selected" : "" ?>>Croatia</option>
                                        <option value="Cuba" <?= ($pcountry == "Cuba") ? "selected" : "" ?>>Cuba</option>
                                        <option value="Cyprus" <?= ($pcountry == "Cyprus") ? "selected" : "" ?>>Cyprus</option>
                                        <option value="Czech Republic"  <?= ($pcountry == "Czech Republic") ? "selected" : "" ?>>Czech Republic</option>
                                        <option value="Denmark" <?= ($pcountry == "Denmark") ? "selected" : "" ?>>Denmark</option>
                                        <option value="Djibouti" <?= ($pcountry == "Djibouti") ? "selected" : "" ?>>Djibouti</option>
                                        <option value="Dominica" <?= ($pcountry == "Dominica") ? "selected" : "" ?>>Dominica</option>
                                        <option value="Dominican Republic"  <?= ($pcountry == "Dominican Republic") ? "selected" : "" ?>>Dominican Republic</option>
                                        <option value="Ecuador" <?= ($pcountry == "Ecuador") ? "selected" : "" ?>>Ecuador</option>
                                        <option value="Egypt" <?= ($pcountry == "Egypt") ? "selected" : "" ?>>Egypt</option>
                                        <option value="El Salvador" <?= ($pcountry == "El Salvador") ? "selected" : "" ?>>El Salvador</option>
                                        <option value="Equatorial Guinea" <?= ($pcountry == "Equatorial Guinea") ? "selected" : "" ?>>Equatorial Guinea</option>
                                        <option value="Eritrea" <?= ($pcountry == "Eritrea") ? "selected" : "" ?>>Eritrea</option>
                                        <option value="Estonia" <?= ($pcountry == "Estonia") ? "selected" : "" ?>>Estonia</option>
                                        <option value="Eswatini" <?= ($pcountry == "Eswatini") ? "selected" : "" ?>>Eswatini</option>
                                        <option value="Ethiopia" <?= ($pcountry == "Ethiopia") ? "selected" : "" ?>>Ethiopia</option>
                                        <option value="Fiji" <?= ($pcountry == "Fiji") ? "selected" : "" ?>>Fiji</option>
                                        <option value="Finland" <?= ($pcountry == "Finland") ? "selected" : "" ?>>Finland</option>
                                        <option value="France" <?= ($pcountry == "France") ? "selected" : "" ?>>France</option>
                                        <option value="Gabon" <?= ($pcountry == "Gabon") ? "selected" : "" ?>>Gabon</option>
                                        <option value="Gambia" <?= ($pcountry == "Gambia") ? "selected" : "" ?>>Gambia</option>
                                        <option value="Georgia" <?= ($pcountry == "Georgia") ? "selected" : "" ?>>Georgia</option>
                                        <option value="Germany" <?= ($pcountry == "Germany") ? "selected" : "" ?>>Germany</option>
                                        <option value="Ghana" <?= ($pcountry == "Ghana") ? "selected" : "" ?>>Ghana</option>
                                        <option value="Greece" <?= ($pcountry == "Greece") ? "selected" : "" ?>>Greece</option>
                                        <option value="Grenada" <?= ($pcountry == "Grenada") ? "selected" : "" ?>>Grenada</option>
                                        <option value="Guatemala" <?= ($pcountry == "Guatemala") ? "selected" : "" ?>>Guatemala</option>
                                        <option value="Guinea" <?= ($pcountry == "Guinea") ? "selected" : "" ?>>Guinea</option>
                                        <option value="Guinea-Bissau" <?= ($pcountry == "Guinea Bissau") ? "selected" : "" ?>>Guinea-Bissau</option>
                                        <option value="Guyana" <?= ($pcountry == "Guyana") ? "selected" : "" ?>>Guyana</option>
                                        <option value="Haiti" <?= ($pcountry == "Haiti") ? "selected" : "" ?>>Haiti</option>
                                        <option value="Honduras" <?= ($pcountry == "Honduras") ? "selected" : "" ?>>Honduras</option>
                                        <option value="Hungary" <?= ($pcountry == "Hungary") ? "selected" : "" ?>>Hungary</option>
                                        <option value="Iceland" <?= ($pcountry == "Iceland") ? "selected" : "" ?>>Iceland</option>
                                        <option value="India" <?= ($pcountry == "India") ? "selected" : "" ?>>India</option>
                                        <option value="Indonesia" <?= ($pcountry == "Indonesia") ? "selected" : "" ?>>Indonesia</option>
                                        <option value="Iran" <?= ($pcountry == "Iran") ? "selected" : "" ?>>Iran</option>
                                        <option value="Iraq" <?= ($pcountry == "Iraq") ? "selected" : "" ?>>Iraq</option>
                                        <option value="Ireland" <?= ($pcountry == "Ireland") ? "selected" : "" ?>>Ireland</option>
                                        <option value="Israel" <?= ($pcountry == "Israel") ? "selected" : "" ?>>Israel</option>
                                        <option value="Italy" <?= ($pcountry == "Italy") ? "selected" : "" ?>>Italy</option>
                                        <option value="Jamaica" <?= ($pcountry == "Jamaica") ? "selected" : "" ?>>Jamaica</option>
                                        <option value="Japan" <?= ($pcountry == "Japan") ? "selected" : "" ?>>Japan</option>
                                        <option value="Jordan" <?= ($pcountry == "Jordan") ? "selected" : "" ?>>Jordan</option>
                                        <option value="Kazakhstan" <?= ($pcountry == "Kazakhstan") ? "selected" : "" ?>>Kazakhstan</option>
                                        <option value="Kenya" <?= ($pcountry == "Kenya") ? "selected" : "" ?>>Kenya</option>
                                        <option value="Kiribati" <?= ($pcountry == "Kiribati") ? "selected" : "" ?>>Kiribati</option>
                                        <option value="Kuwait" <?= ($pcountry == "Kuwait") ? "selected" : "" ?>>Kuwait</option>
                                        <option value="Kyrgyzstan" <?= ($pcountry == "Kyrgyzstan") ? "selected" : "" ?>>Kyrgyzstan</option>
                                        <option value="Laos" <?= ($pcountry == "Laos") ? "selected" : "" ?>>Laos</option>
                                        <option value="Latvia" <?= ($pcountry == "Latvia") ? "selected" : "" ?>>Latvia</option>
                                        <option value="Lebanon" <?= ($pcountry == "Lebanon") ? "selected" : "" ?>>Lebanon</option>
                                        <option value="Lesotho" <?= ($pcountry == "Lesotho") ? "selected" : "" ?>>Lesotho</option>
                                        <option value="Liberia" <?= ($pcountry == "Liberia") ? "selected" : "" ?>>Liberia</option>
                                        <option value="Libya" <?= ($pcountry == "Libya") ? "selected" : "" ?>>Libya</option>
                                        <option value="Liechtenstein" <?= ($pcountry == "Liechtenstein") ? "selected" : "" ?>>Liechtenstein</option>
                                        <option value="Lithuania" <?= ($pcountry == "Lithuania") ? "selected" : "" ?>>Lithuania</option>
                                        <option value="Luxembourg" <?= ($pcountry == "Luxembourg") ? "selected" : "" ?>>Luxembourg</option>
                                        <option value="Madagascar" <?= ($pcountry == "Madagascar") ? "selected" : "" ?>>Madagascar</option>
                                        <option value="Malawi" <?= ($pcountry == "Malawi") ? "selected" : "" ?>>Malawi</option>
                                        <option value="Malaysia" <?= ($pcountry == "Malaysia") ? "selected" : "" ?>>Malaysia</option>
                                        <option value="Maldives" <?= ($pcountry == "Maldives") ? "selected" : "" ?>>Maldives</option>
                                        <option value="Mali" <?= ($pcountry == "Mali") ? "selected" : "" ?>>Mali</option>
                                        <option value="Malta" <?= ($pcountry == "Malta") ? "selected" : "" ?>>Malta</option>
                                        <option value="Marshall Islands" <?= ($pcountry == "Marshall Islands") ? "selected" : "" ?>>Marshall Islands</option>
                                        <option value="Mauritania" <?= ($pcountry == "Mauritania") ? "selected" : "" ?>>Mauritania</option>
                                        <option value="Mauritius" <?= ($pcountry == "Mauritius") ? "selected" : "" ?>>Mauritius</option>
                                        <option value="Mexico" <?= ($pcountry == "Mexico") ? "selected" : "" ?>>Mexico</option>
                                        <option value="Micronesia" <?= ($pcountry == "Micronesia") ? "selected" : "" ?>>Micronesia</option>
                                        <option value="Moldova" <?= ($pcountry == "Moldova") ? "selected" : "" ?>>Moldova</option>
                                        <option value="Monaco" <?= ($pcountry == "Monaco") ? "selected" : "" ?>>Monaco</option>
                                        <option value="Mongolia" <?= ($pcountry == "Mongolia") ? "selected" : "" ?>>Mongolia</option>
                                        <option value="Montenegro" <?= ($pcountry == "Montenegro") ? "selected" : "" ?>>Montenegro</option>
                                        <option value="Morocco" <?= ($pcountry == "Morocco") ? "selected" : "" ?>>Morocco</option>
                                        <option value="Mozambique" <?= ($pcountry == "Mozambique") ? "selected" : "" ?>>Mozambique</option>
                                        <option value="Myanmar" <?= ($pcountry == "Myanmar") ? "selected" : "" ?>>Myanmar</option>
                                        <option value="Namibia" <?= ($pcountry == "Namibia") ? "selected" : "" ?>>Namibia</option>
                                        <option value="Nauru" <?= ($pcountry == "Nauru") ? "selected" : "" ?>>Nauru</option>
                                        <option value="Nepal" <?= ($pcountry == "Nepal") ? "selected" : "" ?>>Nepal</option>
                                        <option value="Netherlands" <?= ($pcountry == "Netherlands") ? "selected" : "" ?>>Netherlands</option>
                                        <option value="New  <?= ($pcountry == "New") ? "selected" : "" ?>Zealand">New Zealand</option>
                                        <option value="Nicaragua" <?= ($pcountry == "Nicaragua") ? "selected" : "" ?>>Nicaragua</option>
                                        <option value="Niger" <?= ($pcountry == "Niger") ? "selected" : "" ?>>Niger</option>
                                        <option value="Nigeria" <?= ($pcountry == "Nigeria") ? "selected" : "" ?>>Nigeria</option>
                                        <option value="North Korea" <?= ($pcountry == "North Korea") ? "selected" : "" ?>>North Korea</option>
                                        <option value="North Macedonia" <?= ($pcountry == "North Macedonia") ? "selected" : "" ?>>North Macedonia</option>
                                        <option value="Norway" <?= ($pcountry == "Norway") ? "selected" : "" ?>>Norway</option>
                                        <option value="Oman" <?= ($pcountry == "Oman") ? "selected" : "" ?>>Oman</option>
                                        <option value="Pakistan" <?= ($pcountry == "Pakistan") ? "selected" : "" ?>>Pakistan</option>
                                        <option value="Palau" <?= ($pcountry == "Palau") ? "selected" : "" ?>>Palau</option>
                                        <option value="Palestine" <?= ($pcountry == "Palestine") ? "selected" : "" ?>>Palestine</option>
                                        <option value="Panama" <?= ($pcountry == "Panama") ? "selected" : "" ?>>Panama</option>
                                        <option value="Papua New Guinea" <?= ($pcountry == "Papua New Guinea") ? "selected" : "" ?>>Papua New Guinea</option>
                                        <option value="Paraguay" <?= ($pcountry == "Paraguay") ? "selected" : "" ?>>Paraguay</option>
                                        <option value="Peru" <?= ($pcountry == "Peru") ? "selected" : "" ?>>Peru</option>
                                        <option value="Philippines" <?= ($pcountry == "Philippines") ? "selected" : "" ?>>Philippines</option>
                                        <option value="Poland" <?= ($pcountry == "Poland") ? "selected" : "" ?>>Poland</option>
                                        <option value="Portugal" <?= ($pcountry == "Portugal") ? "selected" : "" ?>>Portugal</option>
                                        <option value="Qatar" <?= ($pcountry == "Qatar") ? "selected" : "" ?>>Qatar</option>
                                        <option value="Romania" <?= ($pcountry == "Romania") ? "selected" : "" ?>>Romania</option>
                                        <option value="Russia" <?= ($pcountry == "Russia") ? "selected" : "" ?>>Russia</option>
                                        <option value="Rwanda" <?= ($pcountry == "Rwanda") ? "selected" : "" ?>>Rwanda</option>
                                        <option value="Saint Kitts and Nevis" <?= ($pcountry == "Saint Kitts and Nevis") ? "selected" : "" ?>>Saint Kitts and Nevis</option>
                                        <option value="Saint Lucia" <?= ($pcountry == "Saint Lucia") ? "selected" : "" ?>>Saint Lucia</option>
                                        <option value="Saint Vincent and the Grenadines" <?= ($pcountry == "Saint Vincent and the Grenadines") ? "selected" : "" ?>>Saint Vincent and the Grenadines</option>
                                        <option value="Samoa" <?= ($pcountry == "Samoa") ? "selected" : "" ?>>Samoa</option>
                                        <option value="San Marino" <?= ($pcountry == "San Marino") ? "selected" : "" ?>>San Marino</option>
                                        <option value="Sao Tome and Principe" <?= ($pcountry == "Sao Tome and Principe") ? "selected" : "" ?>>Sao Tome and Principe</option>
                                        <option value="Saudi Arabia" <?= ($pcountry == "Saudi Arabia") ? "selected" : "" ?>>Saudi Arabia</option>
                                        <option value="Senegal" <?= ($pcountry == "Senegal") ? "selected" : "" ?>>Senegal</option>
                                        <option value="Serbia" <?= ($pcountry == "Serbia") ? "selected" : "" ?>>Serbia</option>
                                        <option value="Seychelles" <?= ($pcountry == "Seychelles") ? "selected" : "" ?>>Seychelles</option>
                                        <option value="Sierra Leone" <?= ($pcountry == "Sierra Leone") ? "selected" : "" ?>>Sierra Leone</option>
                                        <option value="Singapore" <?= ($pcountry == "Singapore") ? "selected" : "" ?>>Singapore</option>
                                        <option value="Slovakia" <?= ($pcountry == "Slovakia") ? "selected" : "" ?>>Slovakia</option>
                                        <option value="Slovenia" <?= ($pcountry == "Slovenia") ? "selected" : "" ?>>Slovenia</option>
                                        <option value="Solomon Islands" <?= ($pcountry == "Solomon Islands") ? "selected" : "" ?>>Solomon Islands</option>
                                        <option value="Somalia" <?= ($pcountry == "Somalia") ? "selected" : "" ?>>Somalia</option>
                                        <option value="South Africa" <?= ($pcountry == "South Africa") ? "selected" : "" ?>>South Africa</option>
                                        <option value="South Korea" <?= ($pcountry == "South Korea") ? "selected" : "" ?>>South Korea</option>
                                        <option value="South Sudan" <?= ($pcountry == "South Sudan") ? "selected" : "" ?>>South Sudan</option>
                                        <option value="Spain" <?= ($pcountry == "Spain") ? "selected" : "" ?>>Spain</option>
                                        <option value="Sri Lanka" <?= ($pcountry == "Sri Lanka") ? "selected" : "" ?>>Sri Lanka</option>
                                        <option value="Sudan" <?= ($pcountry == "Sudan") ? "selected" : "" ?>>Sudan</option>
                                        <option value="Suriname" <?= ($pcountry == "Suriname") ? "selected" : "" ?>>Suriname</option>
                                        <option value="Sweden" <?= ($pcountry == "Sweden") ? "selected" : "" ?>>Sweden</option>
                                        <option value="Switzerland" <?= ($pcountry == "Switzerland") ? "selected" : "" ?>>Switzerland</option>
                                        <option value="Syria" <?= ($pcountry == "Syria") ? "selected" : "" ?>>Syria</option>
                                        <option value="Tajikistan" <?= ($pcountry == "Tajikistan") ? "selected" : "" ?>>Tajikistan</option>
                                        <option value="Tanzania" <?= ($pcountry == "Tanzania") ? "selected" : "" ?>>Tanzania</option>
                                        <option value="Thailand" <?= ($pcountry == "Thailand") ? "selected" : "" ?>>Thailand</option>
                                        <option value="Timor-Leste" <?= ($pcountry == "Timor Leste") ? "selected" : "" ?>>Timor-Leste</option>
                                        <option value="Togo" <?= ($pcountry == "Togo") ? "selected" : "" ?>>Togo</option>
                                        <option value="Tonga" <?= ($pcountry == "Tonga") ? "selected" : "" ?>>Tonga</option>
                                        <option value="Trinidad and Tobago" <?= ($pcountry == "Trinidad and Tobago") ? "selected" : "" ?>>Trinidad and Tobago</option>
                                        <option value="Tunisia" <?= ($pcountry == "Tunisia") ? "selected" : "" ?>>Tunisia</option>
                                        <option value="Turkey" <?= ($pcountry == "Turkey") ? "selected" : "" ?>>Turkey</option>
                                        <option value="Turkmenistan" <?= ($pcountry == "Turkmenistan") ? "selected" : "" ?>>Turkmenistan</option>
                                        <option value="Tuvalu" <?= ($pcountry == "Tuvalu") ? "selected" : "" ?>>Tuvalu</option>
                                        <option value="Uganda" <?= ($pcountry == "Uganda") ? "selected" : "" ?>>Uganda</option>
                                        <option value="Ukraine" <?= ($pcountry == "Ukraine") ? "selected" : "" ?>>Ukraine</option>
                                        <option value="United Arab Emirates" <?= ($pcountry == "United Arab Emirates") ? "selected" : "" ?>>United Arab Emirates</option>
                                        <option value="United Kingdom" <?= ($pcountry == "United Kingdom") ? "selected" : "" ?>>United Kingdom</option>
                                        <option value="United States" <?= ($pcountry == "United States") ? "selected" : "" ?>>United States</option>
                                        <option value="Uruguay" <?= ($pcountry == "Uruguay") ? "selected" : "" ?>>Uruguay</option>
                                        <option value="Uzbekistan" <?= ($pcountry == "Uzbekistan") ? "selected" : "" ?>>Uzbekistan</option>
                                        <option value="Vanuatu" <?= ($pcountry == "Vanuatu") ? "selected" : "" ?>>Vanuatu</option>
                                        <option value="Vatican City" <?= ($pcountry == "Vatican City") ? "selected" : "" ?>>Vatican City</option>
                                        <option value="Venezuela" <?= ($pcountry == "Venezuela") ? "selected" : "" ?>>Venezuela</option>
                                        <option value="Vietnam" <?= ($pcountry == "Vietnam") ? "selected" : "" ?>>Vietnam</option>
                                        <option value="Yemen" <?= ($pcountry == "Yemen") ? "selected" : "" ?>>Yemen</option>
                                        <option value="Zambia" <?= ($pcountry == "Zambia") ? "selected" : "" ?>>Zambia</option>
                                        <option value="Zimbabwe" <?= ($pcountry == "Zimbabwe") ? "selected" : "" ?>>Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pprice" class="form-label">PRICE:</label>
                                    <input type="number" class="form-control" name="pprice" id="pprice" value="<?= $pprice ?>" min="1" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="pkeywords" class="form-label">KEYWORDS:</label>
                                    <input type="text" class="form-control" name="pkeywords" id="pkeywords" value="<?= $pkeywords ?>" />
                                    <div id="highlighted-keywords" class="mt-3"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">QUANTITY:</label>
                                    <div class="mb-3">
                                        <div class="input-group w-50 w-md-25 quantity bg-white rounded-pill py-3">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border qty-btn" type="button">
                                                    <i class="bx bx-minus"></i>
                                                </button>
                                            </div>
                                            <input id="qty-input" type="text" class="form-control form-control-sm text-center border-0" name="quantity" value="<?= $pquantity ?>" min="1" required>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border qty-btn" type="button">
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
                                    <textarea class="form-control" name="pdescription" id="pdescription" rows="3"><?= $pdescription ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="add-product.php" type="reset" name="cancel" id="cancel-btn" class="btn btn-accent"> Cancel </a>
                                <span class="mx-2"></span>
                                <button type="submit" name="save" id="save-btn" class="btn btn-primary"> Save </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!--    Update Product Section End     -->

    </main>

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>