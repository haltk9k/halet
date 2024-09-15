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
    <title>settings</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <nobr><h1>Settings</h1></nobr>
    <?php include "topnav.php";?>
    <?php include "checkuser.php";?>

    <a href="delacc.php" class="red">delete account?</a> <br> <br>
</body>
</html>