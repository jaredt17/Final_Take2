<?php
/**
 *  Add new comments
 */
session_start();
include 'database.php';

if(!empty($_POST["comment"])) {
  $comment = mysqli_real_escape_string($conn, $_POST["comment"]);

  $sql = "INSERT INTO comments (commentid, userid, comment, commentdate) 
  VALUES (NULL, '".$_SESSION["userid"]."', '" . $comment . "', CURRENT_TIMESTAMP)";

  $conn->query($sql);
}
$conn->close();

header("Location: profile.php?id=" . $_SESSION["userid"]);
?>