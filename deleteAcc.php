<?php
/**
 *  Login user and redirect to profile
 */
session_start();
include 'database.php';

if ( $_SESSION['logged_in'] != 1 ) {
    $_SESSION['message'] = "You must log in before viewing your profile page!";
    header("location: error.php");    
  }

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

$userid = $_SESSION['userid'];

if(!empty($email) && !empty($password)) {

  $sql = "SELECT * from users where email = '$email' AND username = '$username'";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc())
  {
    if(password_verify($password, $row['password'] ))
    {
         //DELETE USER
         //delete comments
         $sql1 = "DELETE FROM comments where userid = '{$userid}'";
         $conn->query($sql1);
         //delete follow
          $sql2 = "DELETE FROM followers where follower_userid = '{$userid}' OR following_userid = '{$userid}'";
          $conn->query($sql2);
  
      $sql3 = "DELETE FROM users WHERE userid = '{$userid}'";
      $conn->query($sql3);
  
      session_unset();
      session_destroy(); 
      header("Location: index.php");
  
    }else{
      $_SESSION['message'] = "You have entered wrong password, try again!";
      header("location: error.php");
    }  
  } 
  }
  
  
$conn->close();
?>