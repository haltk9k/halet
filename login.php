<?php
require_once "database.php";
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
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>email:</label>
        <input type="email" name="email" class="form-control" required> <br>
        <label>password:</label>
        <input type="password" name="password" class="form-control" required> <br> <br>

        <input type="submit" name="login" value="login"> <br> <br>

        <a href="register.php" class="blue">signup?</a>
    </form>
</body>
</html>
<?php
    if(isset($_POST["login"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if($user){
            if(password_verify($password, $user["password"])){
                $_SESSION["user"] = $user['user'];
                $_SESSION["email"] = $email;
                echo"login successful <br>";
                sleep(1);
                header("Location: home.php");                                                                                                                           
            }else{
                echo "<div class='red'>wrong password</div>";
            }
        }else{
            echo "<div class='red'>Invalid email</div>";
        }

        if(empty($email)){
            echo"username missing <br>";
        }
        elseif(empty($password)){
            echo"password missing <br>";
        }

        // else{
        //     // $hash = password_hash($password, PASSWORD_DEFAULT);
        //     // $sql = "INSERT INTO users (user, password)
        //     //         VALUES ('$username','$hash')";

        //     try{
        //         mysqli_query($conn, $sql);
        //         $_SESSION["username"] = $_POST["username"];
        //         $_SESSION["password"] = $_POST["password"];

        //         echo"login successful <br>";
        //         sleep(2);
        //         header("Location: home.php");
        //     }
        //     catch(mysqli_sql_exception){
        //         echo"wrong username";
        //     }
        // }

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