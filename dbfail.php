    <!--    Include Header File     -->
    <?php include('assets/inc/header.php') ?>

    <!--    Include Loader File     -->
    <?php include('assets/inc/loader.php') ?>


    <!--    Database Fail Start  -->
        <section id="dbfail" class="dbfail vh-100">
            <div class="container py-5">
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            
                <strong>Database Connection Fail!</strong> Call Administartor For Help 
            </div>
            <div class="text-center">
                <a class="btn btn-secondary" href="index.php">Return To Home</a>
            </div>
            </div>
        </section>
    <!--    Database Fail End  -->

    <!--    Include Footer   -->
    <?php include('assets/inc/scripts.php') ?>