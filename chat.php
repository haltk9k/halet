<?php
    session_start();
    require_once "database.php";
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE id = {$_SESSION['id']}";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
</head>
<body>
    <nobr><h1>Chat</h1></nobr>
    <?php include "topnav.php";?>
    <?php include "checkuser.php";?>

    <div class="model-dialog">
        <div class="model-content">
            <div class="model-head">
                <h4>Select account to chat with: </h4>
            </div>
            <div class="model-body">
                <input type="text" name="fromUser" value="<?php echo $user['id']; ?>" hidden>
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM users WHERE NOT user = '$username' ORDER BY user ASC";
                $result = mysqli_query($conn, $sql);
                
                echo "<input type='text' id='searchInput' placeholder='search for users...' onkeyup='filterUsers()'> <br>";
                echo "<select name='list' id='list' size='10' onchange='showLink()'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}' data-user='{$row['user']}'>{$row['user']} (ID: {$row['id']})</option>";
                }
                echo "</select> <br><br>";
                
                echo "<div id='linkContainer' style='display:none;'>";
                echo "<a id='userLink' class='blue' href='#'></a>";
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

<script>
    function showLink() {
        var select = document.getElementById('list');
        var selectedOption = select.options[select.selectedIndex];
        var id = selectedOption.value;
        var user = selectedOption.getAttribute('data-user');
        var linkContainer = document.getElementById('linkContainer');
        var userLink = document.getElementById('userLink');
        
        userLink.href = 'chatbox.php?toUser=' + id;
        userLink.textContent = "chat with " + user + " (ID: " + id + ")?";
        
        linkContainer.style.display = 'block';
    }

    function filterUsers() {
        var input, filter, select, options, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        select = document.getElementById('list');
        options = select.getElementsByTagName('option');
        
        for (i = 0; i < options.length; i++) {
            txtValue = options[i].text;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }

    // Show the link for the initially selected option
    window.onload = function() {
        if (document.getElementById('list').options.length > 0) {
            showLink();
        }
    };
</script>
</body>
</html>