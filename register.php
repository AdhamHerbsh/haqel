
<!--    Include Header File     -->
<?php include('assets/inc/header.php') ?>

<!--    Include Loader File     -->
<?php include('assets/inc/loader.php') ?>

<!--    Register Start -->
<section id="register" class="register">
    <div class="bg-image">
        <div class="row m-0">
            <div class="col-12 col-md-4 bg-secondary py-4 px-5 vh-100" data-aos="slide-right" data-aos-duration="1000">
                <div class="mb-3 text-center">
                    <h1 class="text-white">Register</h1>
                </div>
                <form class="col-10 m-auto" action="assets/php/user.php" method="POST">
                    <div class="mb-3">
                        <label for="fname" class="form-label text-white">FIRST NAME:</label>
                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Enter Your First Name" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label text-white">LAST NAME:</label>
                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Your Last Name" />
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label text-white">PHONE:</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter Your Phone Number" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white">ACCOUNT TYPE:</label>
                        <div class="mb-3">
                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="user_type" id="radio-wholesaler" value="wholesaler" /> <label class="form-check-label fw-bold text-white" for="radio-wholesaler">Wholesaler</label> </div>
                            <div class="form-check form-check-inline"> <input class="form-check-input" type="radio" name="user_type" id="radio-retailer" value="retailer" /> <label class="form-check-label fw-bold text-white" for="radio-retailer">Retailer</label> </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label text-white">EMAIL ADDRESS:</label>
                        <input type="email" class="form-control" name="username" id="username" placeholder="Enter Your Email Address" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-white">PASSWORD:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" />
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label text-white">CONFIRM PASSWORD:</label>
                        <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Enter Your Password Again" />
                    </div>
                    <div class="mb-3 text-center">
                        <button class="col-8 btn btn-white shadow fw-bold" type="submit" name="register_submit">Register</button>
                    </div>
                </form>
                <div class="text-center">
                        <a class="text-decoration-underline" href="login.php">I Already Have Account</a>
                </div>
            </div>
            <div class="col-12 col-md-7 align-content-center">
                <div class="col-6 m-auto rounded-2 bg-black-50">
                    <img class="img-fluid" src="assets/img/logo/haqel-logo.png" alt="image not found" />
                </div>
            </div>
        </div>
    </div>

</section>
<!--    Register End -->


<!--    Scripts Files  -->
<?php include('assets/inc/scripts.php') ?>

</body>

</html>