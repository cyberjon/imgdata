<?php
namespace ImageData;

class Uploads
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }
    public function uploadFromUrl($url)
    {
        $name = basename($url);
        $data = file_get_contents($url);
        $new = $this->targetDir.$name;
        $imageFileType = strtolower(pathinfo($new,PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else if (file_exists($new)) {
            echo "Sorry, file already exists.";
        } else {
            file_put_contents($new, $data);
            $this->save($new);
        }
        header("refresh:2; url=index.php");
    }
    public function upload($tempFile, $fileName)
    {
        $targetFile = $this->targetDir.$fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        $check = getimagesize($tempFile);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
          && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($tempFile, $targetFile)) {
                $this->save($targetFile);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
        header("refresh:2; url=index.php");
    }
    public function save($imageFile)
    {
        try {
            $exif = exif_read_data($imageFile, 0, true);
            $brand = $exif["IFD0"]["Make"];
            $camera = $exif["IFD0"]["Model"];
            $software = $exif["IFD0"]["Software"];
            $size = $exif["FILE"]["FileSize"];
            $width = $exif["COMPUTED"]["Width"];
            $height = $exif["COMPUTED"]["Height"];
            $aperture = $exif["COMPUTED"]["ApertureFNumber"];
            $shutterSpeed = $exif["EXIF"]["ExposureTime"];
            $iso = $exif["EXIF"]["ISOSpeedRatings"];
            $focalLength = $exif["EXIF"]["FocalLength"];
            $lens = $exif["EXIF"]["UndefinedTag:0xA434"];

            $db = new DB();
            $sql = "INSERT INTO data ".
                    "(image_file, brand, camera, software, size, width, height, aperture, shutter_speed, iso, focal_length, lens) "."VALUES ".
                    "('$imageFile','$brand','$camera','$software','$size','$width','$height','$aperture','$shutterSpeed','$iso','$focalLength','$lens')";
            $conn = $db->result($sql);
            if ($conn) {
                printf("Record inserted successfully.<br />");
            } else {
                printf("Could not insert record into table");
            }
        } catch (\Throwable $th) {
            
        }
    }
}