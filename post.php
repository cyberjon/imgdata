<?php
namespace ImageData;

require_once 'DB.php';
require_once 'Uploads.php';

error_reporting(0);
ini_set('error_reporting', E_ERROR);

define('TARGET', 'uploads/');

if (isset($_POST["submit"])) {
    try {
        $u = new Uploads(TARGET);
        $temp_file = $_FILES["fileToUpload"]["tmp_name"];
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $u->upload($temp_file, $file_name);
    } catch (\Throwable $th) {
        echo "Sorry, your file was not uploaded.";
        header("refresh:2; url=index.php");
    }
}
else if (isset($_POST["get_image"])) {
    try {
        $u = new Uploads(TARGET);
        $url=$_POST['img_url'];
        $u->uploadFromUrl($url);
    } catch (\Throwable $th) {
        echo "Sorry, your file was not uploaded.";
        header("refresh:2; url=index.php");
    }
} else if (isset($_POST["ajax_data"])) {
    try {
        $id = $_POST['id'];
        $sql = "SELECT * FROM data where id = ".$id;
        $db = new DB();
        $result = $db->result($sql);
        $row = $result->fetch_assoc(); 
        echo(json_encode($row));
    } catch (\Throwable $th) {
        echo 'Error';
    }
}

