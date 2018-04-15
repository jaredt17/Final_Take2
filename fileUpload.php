<?php
session_start();
include 'database.php';
$msg = "";
if(isset($_POST['upload'])){
    $target = "images/".basename($_FILES['images']['name']);

    $images = $_FILES['images']['name'];
    $text = $_POST['text'];

    $sql = "INSERT INTO images (images, text) VALUES ('$images', '$text')";
    $conn->query($sql);

    if(move_uploaded_file($_FILES['images']['tpm_name'], $target)){
        $msg = "Image has been uploaded!";
    }
    else {
        $msg = "Error has occurred with file uploaded";
    }
}
?>