<?php
require_once 'functions.php';
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $temp_file = $_FILES["fileToUpload"]["tmp_name"];
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    upload($temp_file, $target_file);
}
else if(isset($_POST["get_image"])) {
    $url=$_POST['img_url'];
    upload_from_url($url);
}

