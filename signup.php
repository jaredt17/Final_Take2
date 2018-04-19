<?php
/**
 *  Registers the user and redirects to profile
 */

include 'database.php';

$username = mysqli_real_escape_string($conn, $_POST["username"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = mysqli_real_escape_string($conn, $_POST["password"]);

if(!empty($username) && !empty($email) && !empty($password)) {

  $StorePassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

  $sql = "INSERT INTO users (username, email, password)
  VALUES ('".$username."', '".$email."', '".$StorePassword."')";

  if ($conn->query($sql) === TRUE) {
      $_SESSION["userid"] = $conn->insert_id;
      $_SESSION["username"] = $username;
      $_SESSION["logged_in"] = 0;
      header("Location: index.php");
  } else {
      $_SESSION['message'] = "That username, email, or password, is already taken. Try again.";
      header("Location: error.php");
  }
} else {
  echo "Error: Invalid fields";
}
$conn->close();
?>