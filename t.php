<?php
if(isset($_POST['password'])){
    $password = $_POST['password'];
    $hash_password = password_hash("123", PASSWORD_BCRYPT);
    echo $hash_password;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    bs

    <form action="">
        <div class="mb-3">
            <label for="" class="form-label">Hash Password</label>
            <input
                type="text"
                class="form-control"
                name="password"
                id=""
                aria-describedby="helpId"
                placeholder=""
            />
            <small id="helpId" class="form-text text-muted">Help text</small>
        </div>
        
    </form>
</body>
</html>

