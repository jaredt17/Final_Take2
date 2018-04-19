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
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $StorePassword = password_hash($newPass, PASSWORD_BCRYPT, array('cost' => 10));
  }

  if(!empty($oldPass) && !empty($newPass) && !empty($username)) {

    $sql = "SELECT * from users where username = '{$username}'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      if(password_verify($oldPass, $row['password'] ))
      {
        $sql = $conn->query("UPDATE users SET password = '{$StorePassword}' WHERE userid = '{$userid}'");
    
        header("Location: profile.php?id=" . $row["userid"]);
    
      }else{
        $_SESSION['message'] = "You have entered the wrong old password, try again!";
        header("location: error.php");
      }
    
    } 
}else{
    header("location: error.php");
}

   

$conn->close();



?>