<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
require_once "database.php";
include "checkuser.php";
$fromUser = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chatting</title>
    <link rel="stylesheet" href="./css/chatbox.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <a href="chat.php" class="blue">back..</a> <br> <br>
    <div class="chat-container">
        <div class="chat-header">
            <?php
            if (isset($_GET["toUser"])){
                $sql = "SELECT * FROM users WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $_GET['toUser']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                $row = mysqli_fetch_assoc($result);
                echo "<h2>Chat with {$row['user']} <span>(ID: {$row['id']})</span></h2>";
                echo "<input type='hidden' value='{$_GET['toUser']}' id='toUser'>";
            } else {
                echo "<p class='red'>No user selected for chat.</p>";
                exit();
            }
            ?>
        </div>
        <div id="msgBody" class="chat-messages"></div>
        <div class="chat-input">
            <textarea id="message" placeholder="Type your message..."></textarea>
            <div class="input-actions">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </form>
                <div>
                    <button id="delete" class="del">delete selected</button>
                    <button name="send" id="send">Send</button>
                </div>
            </div>
            <input type="hidden" value="<?php echo $fromUser; ?>" id="fromUser">
        </div>
    </div>
    <script type="text/javascript">
        let deleteState = false;
        $("#delete").on("click", function(){
            deleteState = !deleteState;
            $.ajax({
                url: "realtimechat.php",
                method: "POST",
                data: {
                    delete: deleteState,
                    fromUser: $("#fromUser").val(),
                    toUser: $("#toUser").val()
                },
                success: function(data) {
                    $("#msgBody").html(data);
                }
            });
        });
        $(document).ready(function(){
            function loadMessages() {
                $.ajax({
                    url: "realtimechat.php",
                    method: "POST",
                    data: {
                        fromUser: $("#fromUser").val(),
                        toUser: $("#toUser").val()
                    },
                    success: function(data) {
                        $("#msgBody").html(data);
                        $("#msgBody").scrollTop($("#msgBody")[0].scrollHeight);
                    }
                });
            }

            loadMessages();

            $("#send").on("click", function(){
                var message = $("#message").val();
                if(message != "") {
                    $.ajax({
                        url: "message.php",
                        method: "POST",
                        data: {
                            fromUser: $("#fromUser").val(),
                            toUser: $("#toUser").val(),
                            message: message,
                        },
                        success: function(data) {
                            $("#message").val("");
                            loadMessages();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php
if(isset($_POST["upload"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $target_dir = "uploads/"; 
    $target_file = $target_dir .
    basename($_FILES["fileToUpload"]["name"]);


    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ".basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>