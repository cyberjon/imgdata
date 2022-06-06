<?php
require_once 'functions.php';
if(isset($_POST["submit"])) {
    try {
        $target_dir = "uploads/";
        $temp_file = $_FILES["fileToUpload"]["tmp_name"];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        upload($temp_file, $target_file);
    } catch (\Throwable $th) {
        echo "Sorry, your file was not uploaded.";
        header("refresh:2; url=index.php");
    }
}
else if(isset($_POST["get_image"])) {
    try {
        $url=$_POST['img_url'];
        upload_from_url($url);
    } catch (\Throwable $th) {
        echo "Sorry, your file was not uploaded.";
        header("refresh:2; url=index.php");
    }
}

