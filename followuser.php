<?php
/**
 *  Follow user comments
 */
session_start();
include 'database.php';

if(!empty($_POST["userid"])) {
  $userid = mysqli_real_escape_string($conn, $_POST["userid"]);

  if(isset($_POST["unfollow"])) {
    $sql = "DELETE FROM Followers WHERE follower_userid=".$_SESSION["userid"]." AND following_userid=".$userid;
    $conn->query($sql);
  } else {
    $sql = "INSERT INTO Followers (follower_userid, following_userid, followerdate) 
            VALUES ('".$_SESSION["userid"]."', '" . $userid . "', CURRENT_TIMESTAMP)";
    $conn->query($sql);
  }
  
  header("Location: profile.php?id=" . $userid);
}
$conn->close();
?>