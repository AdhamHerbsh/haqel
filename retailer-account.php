    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Retailer Account Start  -->
    <section id="retailer-account" class="retailer-account">
        <!--    Background Image Start  -->
        <div class="col-12 d-none d-md-block bg-image"></div>
        <!--    Background Image End  -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title mb-3">
                    <h1>Retailer Account</h1>
                    <h3 class="text-muted">Fill Form To Do Shopping</h3>
                </div>
                <form class="" action="assets/php/account.php" method="POST" enctype="multipart/form-data">
                    <h4>Enter Business Information</h4>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="bname" class="form-label">BUSNIESS NAME:</label>
                                <input type="text" class="form-control" name="bname" id="bname" placeholder="Enter Name" />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="bemail" class="form-label">BUSNIESS EMAIL:</label>
                                <input type="text" class="form-control" name="bemail" id="bemail" placeholder="Enter Email Address" />
                            </div>
                            <div class="mb-3">
                                <label for="business_segment" class="form-label">BUSNIESS SEGMENT:</label>
                                <select class="form-select form-select-lg" name="business_segment" id="business_segment" >
                                    <option selected>Select one</option>
                                    <option value="local">Local Grocery Store</option>
                                    <option value="supermarket">Supermarket</option>
                                    <option value="hypermarket">Hypermarket</option>
                                    <option value="farmer">Farmer Market</option>
                                    <option value="online">Online Grocery Retailer</option>
                                    <option value="juice">Juice Bar</option>
                                    <option value="smoothie">Smoothie Shop</option>
                                    <option value="caffe">Caffe</option>
                                    <option value="restaurant">Restaurant</option>
                                    <option value="exporter">Exporter</option>
                                    <option value="personal">Personal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">UPLOAD COMMERCIAL REGISTER FILE:</label>
                                <input type="file" class="form-control" name="comm_file" id="comm_file" placeholder="No File Chosen" />
                            </div>
                        </div>

                    </div>
                    <div class="float-end">
                        <button type="reset" name="cancel" id="cancel" class="btn btn-accent"> Cancel </button>
                        <button type="submit" name="submit" id="submit" class="btn btn-primary"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--    Retailer Account End  -->



    <!--    Scripts Files  -->
    <?php include('assets/inc/scripts.php') ?>


    </body>

    </html>