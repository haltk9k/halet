<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
    require_once "database.php";
    include "checkadmin.php";
    echo "you are admin: <b>{$row["admin"]}</b><br><br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin?</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <a href="getaccount.php" class="blue">accountslist</a> <br>
    <a href="home.php" class="blue">go home</a> <br>
</body>
</html>
<?php
    echo"this is the admin only page.
    you can do things only admins can do here";
?>