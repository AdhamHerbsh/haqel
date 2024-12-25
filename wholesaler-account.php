    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>

    <!--    Wholesaler Account Start  -->
    <section id="wholesaler-account" class="wholesaler-account">
        <!--    Background Image Start  -->
        <div class="col-12 d-none d-md-block bg-image"></div>
        <!--    Background Image End  -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="section-title mb-3">
                    <h1>Wholesaler Account</h1>
                    <h3 class="text-muted">Fill Form To Open Your Shop</h3>
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
                                <label class="form-label">BUSNIESS TYPE:</label>
                                <div class="my-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="btype" id="radio-farm" value="farm" />
                                        <label class="form-check-label" for="radio-farm">Farm</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="btype" id="radio-provider" value="provider" checked/>
                                        <label class="form-check-label" for="radio-provider">Provider</label>
                                    </div>
                                </div>
                            </div>
                            <div id="comm_field" class="mb-3">
                                <label for="comm_file" class="form-label">UPLOAD COMMERCIAL REGISTER FILE:</label>
                                <input type="file" class="form-control" name="comm_file" id="comm_file" placeholder="No File Chosen"/>
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
    <!--    Wholesaler Account End  -->



    <!--    Scripts Files  -->
    <?php include('assets/inc/scripts.php') ?>


    </body>

    </html>