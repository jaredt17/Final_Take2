<?php 
session_start();
include 'database.php';

if(isset($_POST['var'])) $var=$_POST['var'];


$sql = "UPDATE comments 
SET likes = likes+1
WHERE commentid =". $var."

";

$conn->query($sql);

$conn->close();

header("Location: profile.php?id=" . $_SESSION["userid"]);

?>