<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: home.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <h1>Register</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>username:</label>
        <input type="text" name="username" required> <br> <br>
        <label>email:</label>
        <input type="email" name="email" required> <br> <br>
        <label>password:</label>
        <input type="password" name="password" required> <br> <br>
        <label>repeat password:</label>
        <input type="password" name="repeat_password" required> <br> <br>

        <input type="submit" name="register" value="register"> <br> <br>

        <a href="login.php" class="blue">login?</a>
    </form>
</body>
</html>
<?php
    if(isset($_POST["register"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        include "database.php";
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $rep_password = filter_input(INPUT_POST, "repeat_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $errors = array();

        if(empty($username)){
            array_push($errors,"username missing");
        }
        elseif(empty($password) || empty($rep_password)){
            array_push($errors,"passwords missing");
        }
        elseif(empty($email)){
            array_push($errors,"email missing");
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors,"invalid email");
        }
        elseif(strlen($password)<6){
            array_push($errors,"password must be at least 6 letters long <br>");
        }
        elseif(strlen($username)<3){
            array_push($errors,"username must be at least 3 letters long <br>");
        }
        elseif($password!==$rep_password){
            array_push($errors,"passwords do not match <br>");
        }

        require_once "database.php"; //connect to database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $row_count = mysqli_num_rows($result);
        if($row_count > 0){
            array_push($errors,"email already exists");
        }

        if(count($errors)>0){
            foreach($errors as $error){
                echo "<br> <div class='red'>$error</div>";
            }
        }

        else{
            $sql = "INSERT INTO users (user, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepare_stmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepare_stmt){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt,"sss",$username,$email,$hash);
                if (mysqli_stmt_execute($stmt)){
                    echo "registerd";
                }
                // mysqli_query($conn, $sql);
                // $_SESSION['username'] = $username;
                // $_SESSION["password"] = $_POST["password"];

                sleep(1);
                header("Location: home.php");
            }
            else{
                die("something went wrong");
            }
        }

        $conn->close();

        // echo"login successful <br>";
        // header("Location: home.php");

        // $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // $sql = "INSERT INTO users (user, password)
        // VALUES ('".$_POST["username"]."','$hash')";

        // mysqli_query($conn, $sql);
        // if(!empty(trim($_POST["username"])) && !empty(trim($_POST["password"]))){
        // }
    }
?>