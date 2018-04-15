<?php
session_start();
include 'database.php';



if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");    
  }



  $useridentify = $_SESSION['userid'];

  if(!empty($_POST)){
    // Process the form
    $oldPass = mysqli_real_escape_string($conn, $_POST["oldPass"]);
    $newPass =  mysqli_real_escape_string($conn, $_POST["newPass"]);
    
    if($oldPass != $newPass){

        // Continue the process
        $sql = "SELECT * FROM Users WHERE userid=6 AND password='".$oldPass."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $newsql= "UPDATE users SET password=".$newPass."WHERE userid=".$useridentify." AND password=".$oldPass." ";
            $conn->query($newsql);
            echo $useridentify;
            echo $newPass, $oldPass;
        }else {
            header("Location: error.php");
        }
}else{
    $_SESSION['message'] = "form was empty" ;
    header("Location: error.php");
}
}

$conn->close();



?>