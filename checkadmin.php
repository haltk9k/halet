<?php
include "database.php";

if(isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $sql = "SELECT admin FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($result)) {
        $admin = $row["admin"];
        if ($admin != 1){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo '1';
        }
    } else {
        echo '0';
    }
    mysqli_stmt_close($stmt);
} else {
    echo '0';
}
?>