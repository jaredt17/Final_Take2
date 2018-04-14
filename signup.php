<?php
/**
 *  Registers the user and redirects to profile
 */
session_start();
include 'database.php';

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

if(!empty($username) && !empty($email) && !empty($password)) {
  $sql = "INSERT INTO Users (username, email, password)
  VALUES ('".$username."', '".$email."', '".$password."')";

  if ($conn->query($sql) === TRUE) {
      $_SESSION["userid"] = $conn->insert_id;
      $_SESSION["username"] = $username;
      $_SESSION["logged_in"] = 0;
      header("Location: index.php");
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error: Invalid fields";
}
$conn->close();
?>