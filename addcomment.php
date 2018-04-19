<?php
/**
 *  Add new comments
 */
session_start();
include 'database.php';

if(!empty($_POST["comment"])) {
  $comment = $_POST["comment"];
  if(strlen($comment) < 201){

    $userid = $_SESSION['userid'];

    //changed to do binding and preparing
    $stmt = $conn->prepare("INSERT INTO comments (commentid, userid, comment, commentdate) 
    VALUES (NULL, ?,?, CURRENT_TIMESTAMP)");

    $special_chars = htmlspecialchars($comment, ENT_QUOTES);
    
    $stmt->bind_param("is", $userid, $special_chars);
    $stmt->execute();
    
   // $sql = "INSERT INTO comments (commentid, userid, comment, commentdate) 
   // VALUES (NULL, '".$_SESSION["userid"]."', '" . htmlspecialchars($comment, ENT_QUOTES) . "', CURRENT_TIMESTAMP)";
   //   $conn->query($sql);
   
  }else{
    $_SESSION['message'] =  "Message was more than 200 characters, try again!";
    echo "<p id = 'posting'> ". $_SESSION['message'] ."</p>";
  }
}
$conn->close();

header("Location: profile.php?id=" . $_SESSION["userid"]);
?>