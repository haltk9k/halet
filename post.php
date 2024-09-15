<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
    require_once "database.php";
    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            echo"you are currently logged in. <br>";
            // echo "are you admin?: <b>{$row["admin"]}</b><br><br>";
            $admin = $row["admin"];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <a href="dashboard.php" class="blue">back to home..</a> <br> <br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="title" placeholder="enter title.." maxlength="128" required> <br> <br>
        <textarea name="content" cols="150" rows="15" placeholder="enter text.." maxlength="8192" required></textarea> <br> <br>
        <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
        <input type="hidden" name="date" value="<?php echo date("Y-m-d h:i:sa"); ?>">
        <button type="button" id="checkAdminStatus">Check Admin Status</button> <br> <br>

        <?php if($admin == 1){?>
            <div id="adminOptions" style="display: none;">
                <label>set as announcement?</label>
                <input type="radio" name="announce" value=1> <b>yes</b>
                <input type="radio" name="announce" value=0> <b>no</b> <br> <br>
            </div>
            <?php
        }?>

        <input type="submit" value="submit?" name="create"> <br> <br>
    </form>

    <script>
    $(document).ready(function() {
        $('#checkAdminStatus').click(function() {
            $.ajax({
                url: 'checkadmin.php',
                type: 'GET',
                success: function(response) {
                    if (response === '0') {
                        $('#adminOptions').show();
                    } else {
                        $('#adminOptions').hide();
                    }
                },
                error: function() {
                    alert('Error checking admin status');
                }
            });
        });
    });
    </script>
</body>
</html>
<?php
    if(isset($_POST["create"]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_SPECIAL_CHARS);
        $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);
        $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);
        $announce = filter_input(INPUT_POST, "announce", FILTER_SANITIZE_SPECIAL_CHARS);

        $sqlInsert = "INSERT INTO posts(title, content, user, announce) VALUES ('$title', '$content', '$user', '$announce')";
        $result = mysqli_query($conn, $sqlInsert);

        if($result) {
            echo "<span class='yellow'>post created</span>";
        }else{
            die("post failed to create");
        }

        // $_SESSION['title'] = $title;
        // $_SESSION['content'] = $content;
        // $_SESSION['date'] = $date;
    }
?>