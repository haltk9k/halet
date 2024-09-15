<?php
include "database.php";

$fromUser = $_POST['fromUser'];
$toUser = $_POST['toUser'];
$delete = isset($_POST['delete']) ? filter_var($_POST['delete'], FILTER_VALIDATE_BOOLEAN) : false;

$output = "";

$sql = "SELECT * FROM chatbox WHERE ((fromUser = ? AND toUser = ?) OR (fromUser = ? AND toUser = ?)) AND hidden = 0 ORDER BY id ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiii", $fromUser, $toUser, $toUser, $fromUser);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$messageId = mysqli_fetch_assoc($result)['id'];

$output = "<style>
    .message-container {
        margin-bottom: 10px;
        display: flex;
        align-items: center; /* This centers items vertically */
    }
    .message-right { justify-content: flex-end; }
    .message-left { justify-content: flex-start; }
    .reg-date { font-size: 10px; margin-bottom: 2px;}
    .message {
        word-wrap: break-word;
        display: inline-block;
        padding: 5px;                                                                                                           
        margin: 0;
    }
    .yellow-bg { background-color: yellow; }
    .blue-bg { background-color: blue; color: white;}
    .delete-btn {
        background-color: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        font-size: 10px;
        line-height: 16px;
        text-align: center;
        cursor: pointer;
        margin: 0 5px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        align-self: center; /* This centers the button vertically within the flex container */
    }
</style>
<script type='text/javascript'>
function hideMessage(element, messageId) {
    element.closest('.container-delete').style.display = 'none';
    
    $.ajax({
        url: 'messagehide.php',
        method: 'POST',
        data: { action: 'hide', messageId: messageId },
        success: function(response) {
            console.log('Message hidden successfully');
        },
        error: function(xhr, status, error) {
            console.error('Error hiding message:', error);
        }
    });
}
</script>";

while($row = mysqli_fetch_assoc($result)){
    if ($row["fromUser"] == $fromUser) {
        $deleteButton = "";
        if ($delete == true) {
            $deleteButton = "<button class='delete-btn' onclick='hideMessage(this, {$row["id"]})'>X</button>";
        }else{
            $deleteButton = "";
        }
        $output .= "<div class='message-container message-right container-delete'>
            {$deleteButton}
            <div class='message-content'>
                <p class='reg-date'>".htmlspecialchars($row['reg_date'])."</p>
                <p class='message yellow-bg'>".nl2br(htmlspecialchars($row['messages']))."</p>
            </div>
        </div>";
    } else {
        $output .= "<div class='message-container message-left'>
            <div>
                <p class='reg-date'>".htmlspecialchars($row['reg_date'])."</p>
                <p class='message blue-bg'>".nl2br(htmlspecialchars($row['messages']))."</p>
            </div>
        </div>";
    }                                                                               
}

echo $output;
?>