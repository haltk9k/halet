<?php
    if(isset($_SESSION["email"])){
        $email = $_SESSION["email"];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            echo"you are currently logged in. <br>";
            echo "username: <span class='yellow'>{$row["user"]}</span><br><br>";
            $_SESSION['username'] = $row["user"];
            $_SESSION['id'] = $row["id"];
        }
    }
?>