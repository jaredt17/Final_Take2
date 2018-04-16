<?php
session_start();
include 'database.php';
$msg = "";

if(isset($_POST['submit'])){
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg', 'png');

    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 500000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'images/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                header("Location: profile.php?uploadsuccess");
            }
                    else{
                     echo "File size is to large!";
                    }
        }
                else{
                echo "There an error uploading the file.";
                }
    }
                else{
                echo "You can't upload this type of image!";
                }


}
?>