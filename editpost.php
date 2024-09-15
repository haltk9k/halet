<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
    if ($_GET['user'] != $_SESSION['username']) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    require_once "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <a href="home.php" class="blue">back to home..</a> <br> <br>
    <h1 class="red">currently broken</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
            $id = $_REQUEST['id'];
            if ($id) {
                $sqlEdit = "SELECT * FROM posts WHERE id = $id";
                $result = mysqli_query($conn, $sqlEdit);

                while ($data = mysqli_fetch_array($result)) { ?>
                    <input type="text" name="title" placeholder="edit title.." value="<?php echo $data['title'];?>"> <br> <br>
                    <textarea name="content" cols="18" rows="7" placeholder="edit text.."><?php echo $data['content'];?></textarea> <br> <br>
                    <input type="hidden" name="date" value="<?php echo date("Y/m/d"); ?>">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
        
                    <input type="submit" value="submit?" name="update"> <br> <br>
                    <?php
                }
            }else{
                echo "no post found";
            }
        ?>
    </form>
</body>
</html>
<?php
    if(isset($_POST["update"]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        include "database.php";
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_SPECIAL_CHARS);
        $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);
        $id = $_GET['id'];
        // $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $sqlUpdate = "UPDATE posts SET title = '$title', content = '$content', reg_date = '$date' WHERE id = $id";
        // $result = mysqli_query($conn, $sqlUpdate);
        if ($conn->query($sqlUpdate) === TRUE) {
            // header("refresh:1,url=home.php");
            echo"<div class='yellow'>edit successful</div>";
        }else{
            die("post failed to edit");
        }

        $conn->close();

        // $_SESSION['title'] = $title;
        // $_SESSION['content'] = $content;
        // $_SESSION['date'] = $date;
    }
?>