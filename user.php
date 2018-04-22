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
  
  public function getMentions() {
    if($_SESSION["userid"] == $this->userid) {
      $mentionID = $_SESSION['username'];
      echo '<div class="panel-heading">People who have mentioned you!</div>';
      echo '<div class="panel-body" style="word-wrap: break-word">';
      $mentionSQL = "SELECT * FROM comments INNER JOIN users ON comments.userId = users.userId WHERE comment LIKE '%$mentionID%'";
      $result = $this->conn->query($mentionSQL);
      $rowcount=mysqli_num_rows($result);
      if($rowcount > 0){
        while($row = $result->fetch_assoc()) {
          //adding profile pics
        echo "<div class='profileimage-infeed'>";
        $sqlImg = "SELECT * FROM profileimg WHERE userid = ".$row['userid'];
        $resultImg = $this->conn->query($sqlImg);

        while($rowImg = $resultImg->fetch_assoc()){

        if($rowImg['status'] == 0){
          echo "<img src = 'uploads/".$row['userid'].".jpg' alt = 'uid.ext'>";
        }else{
          echo "<img src = 'uploads/profiledefault.jpg' alt = 'defaultProf.ext'>";
        }

      echo "</div>";
      }
      //done with profile pic

      
      echo '<small>';
      echo '<a href="profile.php?id='.$row["userid"].'">@'.$row["username"].'</a>'; 
      echo ' &middot; '.date("M d", strtotime($row["commentdate"]));
      echo '</small><br />';
      echo $row["comment"]. "<br />";
      echo '<hr />';


        }
      }else{
        echo '<p>You have not been mentioned by anyone!</p>';
      }


      echo "</div>";
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
        
         //adding profile pics
        echo "<div class='profileimage-infeed'>";
        $sqlImg = "SELECT * FROM profileimg WHERE userid = ".$row['userid'];
        $resultImg = $this->conn->query($sqlImg);

        while($rowImg = $resultImg->fetch_assoc()){

        if($rowImg['status'] == 0){
          echo "<img src = 'uploads/".$row['userid'].".jpg' alt = 'uid.ext'>";
        }else{
          echo "<img src = 'uploads/profiledefault.jpg' alt = 'defaultProf.ext'>";
        }

      echo "</div>";
      }


          echo '<small>';
          echo '<a href="profile.php?id='.$row["userid"].'">@'.$row["username"].'</a>'; 
          echo ' &middot; '.date("M d", strtotime($row["commentdate"]));
          echo '</small><br />';
          echo $row["comment"]. "<br />";
         
          
          //NEED TO ADD LIKES AND DISLIKES BELOW
          
          echo 'Likes: ';
          echo $row['likes'];
         echo " 
          <form action='like.php' method='POST' autocomplete='off'>
          <input type='hidden' name='var' value='".$row['commentid']."'/> 
          <button type='submit' class='button2 button-block2' name='like'/>Like</button> 
          </form>";
         

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
        //adding profile pics
        echo "<div class='profileimage-infeed'>";
        $sqlImg = "SELECT * FROM profileimg WHERE userid = ".$row['userid'];
        $resultImg = $this->conn->query($sqlImg);

        while($rowImg = $resultImg->fetch_assoc()){

        if($rowImg['status'] == 0){
          echo "<img src = 'uploads/".$row['userid'].".jpg' alt = 'uid.ext'>";
        }else{
          echo "<img src = 'uploads/profiledefault.jpg' alt = 'defaultProf.ext'>";
        }

      echo "</div>";
      }

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

  public function getCity(){
    $sql = "SELECT * FROM users WHERE userid =" .$this->userid;
    $result=mysqli_query($this->conn,$sql);
    while($row = $result->fetch_assoc()) {
      echo $row["city"];
      echo ', ';
      echo $row["country"];
      echo '<br>';
    }
  }


}
?>