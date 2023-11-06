<?php

    $hostName = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "loginregisteration";

    $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
    if(!$conn)
    {
        die("Somethin went Wrong!");
    }

?>