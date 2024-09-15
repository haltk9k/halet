<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}
require_once "database.php";

// Handle comment submission
if (isset($_POST["create"]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_SPECIAL_CHARS);
    $post_id = filter_input(INPUT_POST, "post_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $user = $_SESSION["user"];
    $date = date("Y-m-d H:i:s");

    $sqlInsert = "INSERT INTO comments (comment, post_id, user, reg_date) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sqlInsert);
    mysqli_stmt_bind_param($stmt, "ssss", $comment, $post_id, $user, $date);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['success_message'] = "Comment added successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to add comment: " . mysqli_error($conn);
    }

    // Redirect to the same page to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $post_id);
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : null;
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : null;

unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post <?php echo isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : ''; ?></title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <?php
    if (isset($_GET["id"])) {
        $id = mysqli_real_escape_string($conn, $_GET["id"]);
        $sqlSelectPost = "SELECT * FROM posts WHERE id = '$id'";
        $result = mysqli_query($conn, $sqlSelectPost);
        if ($data = mysqli_fetch_array($result)) {
            ?>
            <h1><?php echo htmlspecialchars($data['title']); ?></h1>
            <pre style="font-size:20px; font-weight: bold;"><?php echo nl2br($data['content']); ?></pre>
            <p><?php echo htmlspecialchars($data['reg_date']); ?></p>
            <?php
        } else {
            echo "Post not found";
        }
    } else {
        echo "No post ID provided";
    }
    ?>
    <a href="dashboard.php" class="blue">back..</a><br><br>

    <hr><br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="post">
        <textarea name="comment" cols="150" rows="15" placeholder="Add comment.." maxlength="8192" required></textarea> <br> <br>
        <input type="hidden" name="post_id" value="<?php echo $id; ?>">
        <input type="submit" value="Submit Comment" name="create"> <br> <br>
    </form>

    <hr>
    <div style="font-size: 50px; padding:15px;">COMMENTS:</div>
    <hr>

    <script>
        function isReply() {
            document.getElementById('#reply').style.display = 'none';
        }
    </script>

    <?php
    // Display success or error message
    if (isset($success_message)) {
        echo "<p style='color: yellow;'>" . $success_message . "</p>";
    } elseif (isset($error_message)) {
        echo "<p style='color: red;'>" . $error_message . "</p>";
    }

    // Display comments
    $sqlSelectComments = "SELECT * FROM comments WHERE post_id = '$id' ORDER BY reg_date DESC";
    $result = mysqli_query($conn, $sqlSelectComments);
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="comment">
            <h3><?php echo htmlspecialchars($row['user']); ?></h3>
            <pre style="font-size:16px;"><?php echo htmlspecialchars($row['comment']); ?></pre>
            <div style="display: inline-block; position: relative;"><?php echo htmlspecialchars($row['reg_date']); ?>
                <button onclick="isReply()" style="display: inline-block; font-size:20px;">↵</button><br><br>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="reply">
                <textarea name="reply" cols="150" rows="15" placeholder="Add reply.." maxlength="8192" required></textarea> <br>
                <input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
                <input type="submit" value="reply" name="reply"> <br> <br>
            </form>

        </div>
        <hr>
        <?php
    }
    ?>
</body>
</html>