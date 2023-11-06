<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Registeration Form</title>
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
        if(isset($_POST["submit"]))
        {
            $fullName = $_POST["fullName"];
            $email = $_POST["userEmail"];
            $password = $_POST["userPassword"];
            $passwordrepeate = $_POST["repeatePassword"];

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $erroes = array();

            if(empty($fullName) OR empty($email) OR empty($password) OR empty($passwordrepeate))
            {
                array_push($erroes, "All Fields are Required");
            }
            if(!filter_var($email, FILTER_VALIDATE))
            {
                array_push($erroes, "Email is not valid");
            }
            if(strlen($password) < 8)
            {
                array_push($erroes, "Password must be at last more than 8 characters!");
            }
            if($password !== $passwordrepeate)
            {
                array_push($erroes, "Password does not match!");
            }

            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email' ";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysql_num_rows($result);
            if($rowCount > 0)
            {
                array_push($erroes, "Email already Exist!");
            }

            if(count($erroes)>0)
            {
                foreach($erroes as $erroe)
                    echo"<div class='alert alert-danger'>$erroe</div>";
            }
            else
            {
                $sql = "INSERT INTO users(fullName, email, password	) VALUES( ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $perpareStmt = mysqli_stmt_prepare($stmt, $sql);

                if($perpareStmt)
                {
                    mysqli_stmt_bint_param($stmt, "sss", $fullName, $email, $password_hash);
                    mysqli_stmt_execute($stmt);
                    echo"<div class='alert alert-success'>You are Registered Successfully.</div>";
                }
                else
                {
                    die("Something went Wrong!");
                }
            }
        }
        ?>
        <form action="loinRegisteration.php" method="post">
            <div class="form-group">
            <input type="text" name="fullName" class="formControl" placeholder="Full Name:">
            </div>
            <div class="form-group">
            <input type="email" name="userEmail" class="formControl" placeholder="Email:">
            </div>
            <div class="form-group">
            <input type="password" name="userPassword" class="formControl" placeholder="Password:">
            </div>
            <div class="form-group">
            <input type="text" name="repeatePassword" class="formControl" placeholder="Repeate Password:">
            </div>
            <div class="form-btn">
            <input type="submit" name="submit" class="btn btn-primary" value="Register">
            </div>
        </form>
        <div> <p>Already Register <a href="login.php">Login Here</a> </p> </div>
    </div>
</body>
</html>