<?php
    session_start();        
    require_once "database.php";
    // if (!isset($_SESSION["user"])) {
    //     header("Location: login.php");
    //     exit();
    // }
    include "checkadmin.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <a href="admin.php" class="blue">go back</a> <br>
</body>
</html>
<?php
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql); // First parameter is just return of "mysqli_connect()" function
    echo "<br>";
    echo "<table border='1'>";
    while ($row = mysqli_fetch_assoc($result)) { // Important line, returns assoc array
        echo "<tr>";
        foreach ($row as $field => $value) { 
            echo "<td>" . htmlspecialchars($value) . "</td>"; 
        }
        echo "</tr>";
    }
    echo "</table>";
?>