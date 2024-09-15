<?php
    session_start();
    require_once "database.php";
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <nobr><h1>About</h1></nobr>
    <?php include "topnav.php";?>
    <label>about us</label> <br>
    <p>we are the people of the php</p>
</body>
</html>