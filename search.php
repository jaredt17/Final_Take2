<?php
include "database.php";
session_start();


?>

<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="images/snake.png" type="image/x-icon" />
  <title>Search Results</title>
  <?php include 'css/css.html'; ?>
</head>
<body>
    <!-- NAVBAR AT TOP -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="profile.php?id=<?php echo $_SESSION["userid"] ?>">
                        <img id="brand-image" src="images/snake.png" alt="snake">
                        Hisser - A Sharing Site for Snakes 
      </a>
      <p class="navbar-text">
       Logged in as <a href="profile.php?id=<?php echo $_SESSION["userid"] ?>"><b><?php echo "@".$_SESSION["username"]; ?></b></a></p>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php?id=<?php echo $_SESSION["userid"] ?>">Profile</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="accountSettings.php">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <!-- CONTENT -->
    <div class="container-fluid">

        <div class="row">
      
            <div class="col-lg-2">
                
            </div>
            <div class="col-lg-8">
            <div class = "panel panel-success">
            <div class ="panel-heading">Search Results</div>
            
<?php
if(isset($_POST['search'])){
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM comments INNER JOIN users ON comments.userId = users.userId WHERE comment LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    echo "<div class='panel-body'>";
        echo "<h2>Comments that contain: ".$search."</h2>";
        echo '<hr />';
    if($queryResult > 0){
        
        while($row = mysqli_fetch_assoc($result))
        {

                        //adding profile pics
                        echo "<div class='profileimage-infeed'>";
                        $sqlImg = "SELECT * FROM profileimg WHERE userid = ".$row['userid'];
                        $resultImg = $conn->query($sqlImg);

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
                        echo '<hr />';

        }
      
    }else{
        echo "<p>There were no comments returned for your search, try again.</p>";
        echo '<hr />';
    }

    $sql2 = "SELECT * FROM users WHERE username LIKE '%$search%'";
    $result2 = mysqli_query($conn, $sql2);
    $queryResult2 = mysqli_num_rows($result2);
    echo "<h2>Usernames matching: ".$search."</h2>";
    echo '<hr />';
    if($queryResult2 > 0){
        while($row = mysqli_fetch_assoc($result2))
        {

                        //adding profile pics
                        echo "<div class='profileimage-infeed'>";
                        $sqlImg = "SELECT * FROM profileimg WHERE userid = ".$row['userid'];
                        $resultImg = $conn->query($sqlImg);

                        while($rowImg = $resultImg->fetch_assoc()){

                        if($rowImg['status'] == 0){
                        echo "<img src = 'uploads/".$row['userid'].".jpg' alt = 'uid.ext'>";
                        echo '<a href="profile.php?id='.$row["userid"].'">@'.$row["username"].'</a>';
                        }else{
                        echo "<img src = 'uploads/profiledefault.jpg' alt = 'defaultProf.ext'>";
                        echo '<a href="profile.php?id='.$row["userid"].'">@'.$row["username"].'</a>';
                        }

                        echo "</div>";
                        }
            }



    }else{
        echo "<p>There were no Users returned for your search, try again.</p>";
    }





    echo "</div>";
}
?>
</div> <!--END OF PANEL -->
            </div>
            <div class="col-lg-2">
                  
            </div>
        </div>
    </div>
                
    <!-- Footer -->
    <footer class="footer bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy;Hisser Sharing</p>
        </div>
        <!-- /.container -->
    </footer> 
       <!-- Bootstrap core JavaScript -->
        <script src="css/jquery/jquery.min.js"></script>
        <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>

</body>
</html>