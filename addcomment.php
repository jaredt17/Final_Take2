<?php
/**
 *  Add new comments
 */
session_start();
include 'database.php';

if(!empty($_POST["comment"])) {
  $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
  if(strlen($comment) < 201){
    $sql = "INSERT INTO comments (commentid, userid, comment, commentdate) 
    VALUES (NULL, '".$_SESSION["userid"]."', '" . $comment . "', CURRENT_TIMESTAMP)";
      $conn->query($sql);
  }else{
    $_SESSION['message'] =  "Message was more than 200 characters, try again!";
    echo "<p id = 'posting'> ". $_SESSION['message'] ."</p>";
  }
}
$conn->close();

header("Location: profile.php?id=" . $_SESSION["userid"]);
?>