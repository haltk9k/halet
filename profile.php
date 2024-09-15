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
    <title>profile</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <nobr><h1>Profile</h1></nobr>
    <?php
    include "topnav.php";
    include "checkuser.php";
    ?>
</body>
</html>
<?php
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql); // First parameter is just return of "mysqli_connect()" function
    while ($row = mysqli_fetch_assoc($result)) {
        echo"<b class='blue'>";
        // echo "ID: ".htmlspecialchars($row['id'])."<br>";
        echo "USERNAME: ".htmlspecialchars($row['user'])."<br>";
        echo "EMAIL: ".htmlspecialchars($row['email'])."<br>";
        echo "REGISTERATION DATE: ".htmlspecialchars($row['reg_date'])."<br>";
        if (htmlspecialchars($row['admin']) == 1){
            echo 'ADMIN?: yes';
        }else{
            echo 'ADMIN?: no';
        }
        echo"</b>";
    }
?>