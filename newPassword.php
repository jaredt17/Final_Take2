<?php
session_start();
include 'database.php';



if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");    
  }

  $userid = $_SESSION['userid'];

  if(!empty($_POST)){
    // Process the form
    $oldPass = mysqli_real_escape_string($conn, $_POST["oldPass"]);
    $newPass =  mysqli_real_escape_string($conn, $_POST["newPass"]);
    
    if($oldPass != $newPass){

        // Continue the process
        $sql = "SELECT * FROM users WHERE userid= '$userid' AND password= '$oldPass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {   
            //Change user info here
            $sql = $conn->query("UPDATE users SET password = '{$newPass}' WHERE userid = '{$userid}'");
        
        }else{
            $_SESSION['message'] = "Please enter a valid old password.";
            header("Location: error.php");
        }

        }else{
    $_SESSION['message'] = "Please make sure these fields are different.";
    header("Location: error.php");
}
}

$conn->close();



?>