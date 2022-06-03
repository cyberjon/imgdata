<?php
error_reporting(0);
ini_set('error_reporting', E_ERROR);

function upload_from_url($url){
    $target_dir = "uploads/";
    $name = basename($url);
    $data = file_get_contents($url);
    $new = $target_dir.'/'.$name;
    $imageFileType = strtolower(pathinfo($new,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else if(file_exists($new)) {
        echo "Sorry, file already exists.";
    }
    else{
        file_put_contents($new, $data);
        save($new);
    }
    header("refresh:2; url=index.php");
}

function upload($temp_file, $target_file){

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($temp_file);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($temp_file, $target_file)) {
            $image_file = $target_file;
            save($image_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
    header("refresh:2; url=index.php");
}
function save($image_file){
    try {
        $exif = exif_read_data($image_file, 0, true);
        $brand = $exif["IFD0"]["Make"];
        $camera = $exif["IFD0"]["Model"];
        $software = $exif["IFD0"]["Software"];
        $size = $exif["FILE"]["FileSize"];
        $width = $exif["COMPUTED"]["Width"];
        $height = $exif["COMPUTED"]["Height"];
        $aperture = $exif["COMPUTED"]["ApertureFNumber"];
        $shutter_speed = $exif["EXIF"]["ExposureTime"];
        $iso = $exif["EXIF"]["ISOSpeedRatings"];
        $focal_length = $exif["EXIF"]["FocalLength"];
        $lens = $exif["EXIF"]["UndefinedTag:0xA434"];

        require_once 'config.php';

        $conn       = new mysqli( $db_host, $db_user, $db_pass, $db_name );
        $sql = "INSERT INTO data ".
                "(image_file, brand, camera, software, size, width, height, aperture, shutter_speed, iso, focal_length, lens) "."VALUES ".
                "('$image_file','$brand','$camera','$software','$size','$width','$height','$aperture','$shutter_speed','$iso','$focal_length','$lens')";
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        if ($conn->query($sql)) {
            printf("Record inserted successfully.<br />");
        }
        if ($conn->errno) {
            printf("Could not insert record into table: %s<br />", $conn->error);
        }
        $conn->close();
    } catch (\Throwable $th) {
        
    }
}
?>