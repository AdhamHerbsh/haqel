    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>


    <!--    Background Image Start  -->
        <div class="col-12 vh-100 bg-image"></div>
    <!--    Background Image End  -->
    
    <!--    Login Start  -->
    <section id="login" class="col-10 col-md-3 bg-white py-5 px-2 rounded-2 login">
        <div class="container">
            <div class="text-center">
                <div class="col-12 logo mb-3">
                    <img src="assets/img/logo/haqel-logo-thumbnail.png" class="img-fluid w-25" alt="image not found" />
                </div>
                <div class="mb-3">
                    <h1>Login</h1>
                </div>
            </div>
            <form class="col-10 m-auto" action="assets/php/user.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">USERNAME:</label>
                    <input type="email" class="form-control" name="username" id="email" placeholder="Enter Your Username" />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">PASSWORD:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password" />
                </div>
                <div class="mb-3 text-center">
                    <button class="col-8 btn btn-primary shadow fw-bold" type="submit" name="login_submit">Login</button>
                </div>
            </form>
            <div class="text-center">
                <a class="text-decoration-underline" href="register.php">I Don’t Have Account!</a>
            </div>
        </div>
    </section>
    <!--    Login End  -->

    <!--    Scripts Files  -->
    <?php include('assets/inc/scripts.php') ?>


    </body>

    </html>