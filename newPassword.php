<?php
session_start();
include 'database.php';



if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");    
  }

  if(!empty($_POST)){
    // Process the form
     
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
     
    
    if($oldPass != $newPass){
        // Continue the process
        $oldPass = $conn->real_escape_string($oldPass);
        $newPass = $conn->real_escape_string($newPass);

        $sql = "SELECT password FROM users WHERE userid= ".$_SESSION['userid']'.";
        $query = $conn->query($sql);
         
        $pass = $query->fetch_assoc();
        if($pass['password'] == $oldPass){
            $sql = "UPDATE users SET password='".$newPass."WHERE userid=". $_SESSION['userid'];
            $conn->query($sql);
        }

    }
    else {
        $error = 'Please provide both your current password and your new password.';
    }
}

$conn->close();
header("Location: profile.php?id=" . $_SESSION["userid"]);


?>