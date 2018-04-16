<?php
/**
 *  Login user and redirect to profile
 */
session_start();
include 'database.php';

$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

if(!empty($email) && !empty($password)) {

  $sql = "SELECT * from users where email = '$email'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  
  if(password_verify($password, $row['password'] ))
  {
       //Login user
    $_SESSION["userid"] = $row["userid"];
    $_SESSION["username"] = $row["username"];
    $_SESSION["logged_in"] = 1;

    header("Location: profile.php?id=" . $row["userid"]);

  }else{
    $_SESSION['message'] = "You have entered wrong password, try again!";
    header("location: error.php");
  }
  //Check email and password

} else {
  echo "Error: Invalid fields";
}
$conn->close();
?>