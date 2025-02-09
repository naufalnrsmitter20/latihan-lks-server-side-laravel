<?php 

$target_dir = "upload/";
$target_file = $target_dir.basename($_FILES["cover"]["name"]);
$uploadOK = 1;
$imageFileType = strtolower( pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST["submit"])){
    $check = getimagesize(filename: $_FILES["cover"]["tmp_name"]);
    if($check !== false){
        echo "File is an Image - ".$check["mime"].".";
        $uploadOK = 1;
    } else{
        echo "File is not an image.\n";
        $uploadOK = 0;
    }
}

// check file is already exists
if(file_exists($target_file)){
    echo "Sorry, file is already exists\n";
    $uploadOK = 0;
}

// set maximum size
if($_FILES["cover"]["size"] > 200000000){
    echo "sorry, your file is too large\n";
    $uploadOK = 0;
}

// set allowed file type
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" && $imageFileType != "ico"){
    echo "sorry, only JPG, PNG, WEBP, and ICO file can upload in here!\n";
    $uploadOK = 0;
}

if($uploadOK == 0){
    echo "Sorry, your file cannot upload\n";
} else{
    if(move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file)){
        echo "This file" . htmlspecialchars(basename($_FILES["cover"]["tmp_name"])) . " has been created";
    } else{
        echo "Your file failed to upload!\n";
    }
}
?>