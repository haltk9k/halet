<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "pagedb";

    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if(!$conn){
        die("could not connect//" . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8");
?>