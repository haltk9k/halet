<?php
    session_start();
    require_once "database.php";
    if (!isset($_SESSION["user"])) {
        header("Location: home.php");
        exit();
    }
    if ($_GET['user'] != $_SESSION['username']) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete post <?php echo $_GET["id"]; ?></title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <?php
        $id = $_GET["id"];
        if ($id) {
            $sqlDelete = "DELETE FROM posts WHERE id = $id";
            if ($conn->query($sqlDelete) === TRUE) {
                // $id = $id-1;
                echo "deleted successfully";
                // $sqlDeleteID = "ALTER TABLE posts AUTO_INCREMENT=$id";
                // if ($conn->query($sqlDeleteID) === TRUE){
                //     echo "!";
                // }else{
                //     echo "something went wrong";
                // }
            } else {
            echo "Error: " . $conn->error;
            }
                
            $conn->close();
        }
    ?>
    <a href="#" onclick="goBack(); return false;" class="blue">back..</a>
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</body>
</html>