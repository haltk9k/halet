<?php
session_start();
include "database.php";

$fromUser = $_POST['fromUser'];
$toUser = $_POST['toUser'];
$message = $_POST['message'];

$output = "";

$sql = "INSERT INTO chatbox (fromUser, toUser, messages) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iis", $fromUser, $toUser, $message);

if(mysqli_stmt_execute($stmt)){
    $output .= "Message sent successfully";
} else {
    $output .= "Error: " . mysqli_error($conn);
}

echo $output;
?>