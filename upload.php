<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
    </form>
</body>

<?php
if(isset($_POST["send"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
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