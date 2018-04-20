<?php
include 'database.php';
session_start();

$imguserid = $_SESSION['userid'];

if(isset($_POST['submit'])){
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));
//for now we will only allow jpg
$allowed = array('jpg');

if(in_array($fileActualExt, $allowed)){
    if($fileError === 0){
        if($fileSize < 1048580){
            $fileNameNew = $imguserid.".".$fileActualExt;
            $fileDestination = 'uploads/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            $sql = "UPDATE profileimg SET status=0 WHERE userid='$imguserid'";
            $result = $conn->query($sql);
            header("Location: profile.php?id=" .$_SESSION["userid"]);

        }else{
            echo "File was too large, try again!";
        }

    }else{
        echo "Please upload using a JPG image file!";
    }


}else{
    $_SESSION['message'] = "There was an error while uploading... Try again!";
    echo "<div class='form'>";
    echo "<h1>Error</h1>";
    echo "<p>";
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo $_SESSION['message'];    
    else:
        header("Location: profile.php?id=" . $_SESSION["userid"]);
    endif;

    echo "</p>";
    echo "<a href= 'profile.php?id= ".$_SESSION["userid"]."' >Profile</a>";
echo "</div>";
}


}

 

?>