<?php
    session_start();
    require_once "database.php";
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <style>
    table {
    border-collapse: collapse;
    width: 35%;
    }

    th, td {
    border: 2px solid blue;
    padding: 2.5px;
    }

    td, td a, b {
        background-color: lightblue;
    }

    td a{
        color: blue;
    }

    th {
    background-color: cornflowerblue;
    }
    </style>
</head>
<body>
    <nobr><h1>Dashboard</h1></nobr>
    <?php include "topnav.php";?>
    <label>||post things in the Dashboard||</label> <br> <br>
    <?php include "checkuser.php";?>
    <a href="post.php" class="blue">add post?</a> <br> <br>
    <div>
        <table border='1'>
            <thead>
                <tr>
                    <th>title</th>
                    <th>username</th>
                    <th>date</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody class="truncate">
                <tr>
                <?php
                    $sqlSelect = "SELECT * FROM posts ORDER BY
                                CASE
                                    WHEN announce = 1 THEN 0 ELSE 1
                                END,
                                    id ASC;";
                    $result = mysqli_query($conn, $sqlSelect);
                    while($data = mysqli_fetch_array($result)){
                    ?>
                    <td>
                        <?php if($data["announce"] == 1){ echo "<b class='yellow'>{$data["title"]}</b>";
                            echo "<b class='yellow'> [!]</b>";
                        }else{
                            echo $data["title"];
                        }?>
                    </td>
                    <td><?php echo $data["user"]?></td>
                    <td><?php echo $data["reg_date"]?></td>
                    <td>
                        <a href="viewpost.php?id=<?php echo $data["id"] ?>&user=<?php echo $data["user"] ?>">view</a>
                        <a href="editpost.php?id=<?php echo $data["id"] ?>&user=<?php echo $data["user"] ?>">edit</a>
                        <a href="delpost.php?id=<?php echo $data["id"] ?>&user=<?php echo $data["user"] ?>" class="red">delete</a>
                    </td>
                </tr>
                    <?php
                    }
                    ?>
            </tbody>
        </table>
    </div>
</body>
</html>