<?php
    session_start();
    if(isset($_SESSION["user"]))
    {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
    body
    {
        padding: 50px;
    }
    .container
    {
        max-width: 600px;
        margin: 0 auto;
        padding: 50px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }
    .form-group
    {
        margin-bottom: 30px;
    }
    a
    {
        text-decoration: none
    }
    </style>
</head>
<body>
    <div class="container">
    <?php
    if(isset($POST["login"]))
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        require_once "database.php";

        $sql = "SLECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($user)
        {
            if(password_verify($password, $user["password"]))
            {
                session_start();
                $_SESSION["user"] = "Yes";
                header("Location: index.php");
                die();
            }else
            {
                echo"<div class'alert alert-danger'>Password does not Match!</div>"; 
            }
        }
        else
        {
            echo"<div class'alert alert-danger'>Email does not Match!</div>";
        }
    }
    ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div> <p>Not Register Yet <a href="loginRegisteration.php">Register Here</a> </p> </div>
    </div>
</body>
</html>