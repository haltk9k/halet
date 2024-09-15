<?php
include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'hide') {
    $messageId = isset($_POST['messageId']) ? intval($_POST['messageId']) : 0;
    
    if ($messageId > 0) {
        $sql = "UPDATE chatbox SET hidden = 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $messageId);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid message ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

mysqli_close($conn);
?>