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
    <title>Home Page</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <nobr><h1>Homepage</h1></nobr> 
    <?php include "topnav.php";?>
    <label>Welcome to the Homepage</label> <br> <br>
    <?php include "checkuser.php";?>
    <?php
        if (isset($_POST["logout"]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            session_destroy();
            sleep(1);
            header("Location: login.php");
            exit();
        }
    ?>

    <a href="admin.php" class="blue">admin?</a> <br> <br>

    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <br> <input type="submit" name="logout" value="logout">
    </form> <br> <br>
</body>
</html>