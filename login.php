<?php
/**
 *  Login user and redirect to profile
 */
session_start();
include 'database.php';

$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

if(!empty($email) && !empty($password)) {
  //Check email and password
  $sql = "SELECT userid, username FROM Users WHERE email='".$email."' AND password='".$password."'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    //Login user
    $row = $result->fetch_assoc();
    $_SESSION["userid"] = $row["userid"];
    $_SESSION["username"] = $row["username"];
    $_SESSION["logged_in"] = 1;
    //Redirect to profile
    header("Location: profile.php?id=" . $row["userid"]);
  } else {
    $_SESSION['message'] = "You have entered wrong password, try again!";
    header("location: error.php");
}
} else {
  echo "Error: Invalid fields";
}
$conn->close();
?>