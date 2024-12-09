    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Include Navbar File     -->
    <?php include('assets/inc/nav.php') ?>

    <!-- Hero Start -->
    <div id="hero" class="container-fluid py-5 hero-header">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h1 class="p-2 mb-4 border-start border-4 border-primary display-1">Fresh & Healthy
                        <br>
                        <span>Organic Food</span>
                    </h1>
                    <a class="col-12 col-md-4 btn btn-primary py-2 px-3 fw-bold text-white fs-4" href="login.php">
                        Shop Now
                        <i class="bx bx-right-arrow-alt bx-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- About Start-->
    <section id="about" class="about">
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title">
                    <h1>About Us</h1>
                    <h3 class="text-muted">Know More About Us</h3>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-6">
                        <p class="lead pe-2">
                            Haqel is a pioneering platform designed to transform the supply chain for fruits and vegetables by connecting retailers, wholesalers, and farmers in a seamless and efficient digital marketplace. Our mission is to address the challenges of communication, logistics, and pricing fluctuations within the industry, offering tools like predictive pricing, real-time tracking, and secure transactions. By leveraging modern technology, Haqel not only simplifies operations but also empowers local businesses to thrive, aligning with the goals of sustainability and digital transformation outlined in Saudi Vision 2030. At Haqel, we are committed to fostering transparency, trust, and growth for all stakeholders.
                        </p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="container">
                            <img class="img-fluid shadow rounded-2" src="assets/img/logo/haqel-logo.png" alt="image not found" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About End-->

    <!-- Categories Start-->
    <section id="categories" class="categories">
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title">
                    <h1>Categories</h1>
                    <h3 class="text-muted">See Fresh Products</h3>
                </div>
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" slides-per-view="auto" space-between="5" free-mode="true">
                    <swiper-slide>
                        <a class="card shadow m-md-4" href="login.php">
                            <img src="assets/img/categories/post-vegetables.png" alt="image not found">
                            <div class="overlay">
                                <p class="text-white fs-md-2 fw-bold">Vegetables <br /> Pick Order</p>
                            </div>
                        </a>
                    </swiper-slide>
                    <swiper-slide>
                        <a class="card shadow m-md-4" href="login.php">
                            <img src="assets/img/categories/post-fruits.png" alt="image not found">
                            <div class="overlay">
                                <p class="text-white fs-md-2 fw-bold">Fruits <br /> Pick Order</p>
                            </div>
                        </a>
                    </swiper-slide>
                </swiper-container>
            </div>
        </div>
    </section>
    <!-- Categories End-->

    <!-- Services Start-->
    <section id="services" class="services">
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title">
                    <h1>Services</h1>
                    <h3 class="text-muted">Choose What You Want</h3>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3 m-auto my-2">
                        <a class="card p-4" href="login.php">
                            <img class="card-img w-50 m-auto img-fluid" src="assets/img/icons/icons8-receipt-96.png" alt="image not found" />
                            <div class="card-body text-center">
                                <h4 class="card-title">Sale Products</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3 m-auto my-2">
                        <a class="card p-4" href="login.php">
                            <img class="card-img w-50 m-auto img-fluid" src="assets/img/icons/icons8-buying-96.png" alt="image not found" />
                            <div class="card-body text-center">
                                <h4 class="card-title">Sale Products</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-3 m-auto my-2">
                        <a class="card p-4" href="login.php">
                            <img class="card-img w-50 m-auto img-fluid" src="assets/img/icons/icons8-chart-96.png" alt="image not found" />
                            <div class="card-body text-center">
                                <h4 class="card-title">Predictive</h4>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Services End-->

    <!-- Contact Start-->
    <section id="contact" class="contact">
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title">
                    <h1>Contact Us</h1>
                    <h3 class="text-muted">Let's Contact With Us</h3>
                </div>
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-12 col-md-6">
                        <div class="container">
                            <form class="" action="">
                                <div class="mb-3">
                                    <label for="full-name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" name="full-name" id="full-name" placeholder="Enter Your Full Name" />
                                </div>
                                <div class="mb-3">
                                    <label for="telephone" class="form-label">Phone:</label>
                                    <input type="tel" class="form-control" name="telephone" id="telephone" placeholder="Enter Your Phone Number" />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" />
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message:</label>
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="5" placeholder="Message"></textarea>
                                </div>
                                <div class="float-end">
                                    <button type="button" name="submit" id="submit" class="btn btn-accent"> May Be Later </button>
                                    <button type="button" name="submit" id="submit" class="btn btn-primary"> Send </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="rounded-2">
                            <div class="card shadow m-md-4">
                                <img class="img-fluid" src="assets/img/posters/poster-1.png" alt="image not found" />
                                <div class="overlay text-center">
                                    <div class="mb-3">
                                        <small class="text-black">ASK ABOUT</small>
                                    </div>
                                    <div class="mb-3">
                                        <h1 class="text-primary fs-md-2 fw-bold">OUR PRODUCTS</h1>
                                    </div>
                                    <div class="mb-3">
                                        <a class="btn btn-outline-primary" href="login.php">Shop Now <i class="bx bx-right-arrow-alt"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contect End-->

    <!--    Include Footer   -->

    <?php include('assets/inc/footer.php') ?>