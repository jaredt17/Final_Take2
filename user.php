<?php
/**
 *  User class
 *  Contains all user related functions
 */
ob_start();
class User
{
  public $conn;
  public $userid;
  public $username;
  
  public function __construct($userid) {
    $this->conn = $GLOBALS["conn"];
    $this->userid = $userid;
    $this->initUser($userid);
  }
  
  private function initUser($userid) {
    $sql = "SELECT * FROM users WHERE userid='{$this->userid}'";
    $result = $this->conn->query($sql);
    $rowcount=mysqli_num_rows($result);
    if ($rowcount > 0) {
      while($row = $result->fetch_assoc()){
        $this->username = $row["username"];
      }
    }
  }
  
  public function getFeed() {
    if($_SESSION["userid"] == $this->userid) {
      echo '<div class="panel-heading">Your feed</div>';
      $followingSql = "SELECT following_userid FROM followers WHERE follower_userid=".$this->userid;
      $sql = "SELECT * FROM comments 
              INNER JOIN users ON comments.userId = users.userId 
              WHERE comments.userid=".$this->userid." OR comments.userid IN (".$followingSql.") ORDER BY commentdate DESC";
      
      $result = $this->conn->query($sql);
      $rowcount=mysqli_num_rows($result);
      if ($rowcount > 0) {
        echo '<div class="panel-body" style="word-wrap: break-word">';
        while($row = $result->fetch_assoc()) {
          echo '<small>';
          echo '<a href="profile.php?id='.$row["userid"].'">'.$row["username"].'</a>'; 
          echo ' &middot; '.date("M d", strtotime($row["commentdate"]));
          echo '</small><br />';
          echo $row["comment"]. "<br />";
              //NEED TO ADD LIKES AND DISLIKES BELOW
              




          echo '<hr />';
        }
        echo '</div>';   
      }
      else{
        echo '<p style="font-size: 200%">You have no hisses yet!</p>';
      }
    }
    
  }

  public function getFollowButton() {
    if($_SESSION["userid"] != $this->userid) {
      $sql="SELECT * FROM followers WHERE follower_userid=" . $_SESSION["userid"] . " AND following_userid=" . $this->userid;

      $result=mysqli_query($this->conn,$sql);
      if(mysqli_num_rows($result)) {
        echo '<input type="submit" id = "followButton" name="unfollow" value="Unfollow">';
      } else {
        echo '<input type="submit" id = "followButton" name="follow" value="Follow">';
      }
    }
  }
  
  public function getPosts() {

    if($_SESSION["userid"] != $this->userid) {

      $sql = "SELECT * FROM comments 
      INNER JOIN users ON comments.userId = users.userId 
      WHERE comments.userid=".$this->userid." ORDER BY commentdate DESC";

      $result = $this->conn->query($sql);
      $rowcount=mysqli_num_rows($result);
    if ($rowcount > 0) {
      echo '<div class="panel-body" style="word-wrap: break-word">';
      
      while($row = $result->fetch_assoc()) {
        echo '<small>';
        echo '<a href="profile.php?id='.$row["userid"].'">'."@".$row["username"].' '.'</a>'; 
        echo ' &middot; '.date("M d", strtotime($row["commentdate"]));
        echo '</small><br />';
        echo $row["comment"]. "<br />";
           //NEED TO ADD LIKES AND DISLIKES BELOW






        echo '<hr />';
      }

      echo '</div>';   
      
  }else{
    echo '<p style="font-size: 200%">This User has no hisses yet!</p>';
  }

  }
}
  
  public function getOtherUsers() {
    $sql = "SELECT * FROM users WHERE userid<>" . $this->userid . " AND userid<>" . $_SESSION["userid"];
    $result = $this->conn->query($sql);
      echo "<ul style='list-style-type:none'>";
      while($row = $result->fetch_assoc()) {
        echo '<li><a href="profile.php?id=' . $row["userid"] . '">' ."@". $row["username"] . " " . '</a></li>';
      }
      echo "</ul>";
  }
  
  public function getNumFollowers() {
    $sql="SELECT * FROM followers WHERE following_userid=" . $this->userid;
    $result=mysqli_query($this->conn,$sql);
    return mysqli_num_rows($result);
  }
  
  public function getNumFollowing() {
    $sql="SELECT * FROM followers WHERE follower_userid=" . $this->userid;
    $result=mysqli_query($this->conn,$sql);
    return mysqli_num_rows($result);
  }
  

}
?>