<!--    Include Header File     -->
<?php include('assets/inc/header.php') ?>

<!--    Include Loader File     -->
<?php include('assets/inc/loader.php') ?>


<?php
$password = "Passwrod Appare Here!";

if (isset($_POST['password'])) {
    $hashed = $_POST['password'];
    $password = password_hash($hashed, PASSWORD_BCRYPT);
}
?>
<main>
    <section>
        <div class="container">

            <form class="" action="" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Hash Password</label>
                    <input type="text" class="form-control" name="password" id="" placeholder="Enter hashed Password" />
                </div>
                <div class="mb-3">
                    <p><?= $password ?></p>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary fw-bold" type="submit">Submit</button>
                </div>
            </form>
        </div>

    </section>
</main>
<!--    Include Footer   -->
<?php include('assets/inc/footer.php') ?>







Fruits:
Mango
Banana
Grapes
Apple
Orange
Pomegranate
Pear
Watermelon
Strawberry
Kiwi



Vegetables:
Green pepper
Cucumber
Onion
Cilantro (Herb)
Green chili
Parsley (Herb)
Eggplant
Carrot
Potato
Tomato (Botanically a fruit, but commonly treated as a vegetable)