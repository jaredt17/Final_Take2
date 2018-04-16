<?php
/**
 *  Profile
 *  Shows user profile and comments
 */
session_start();
include 'database.php';
include 'user.php';

if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");    
}

if(isset($_GET["id"])) :
  $userid = mysqli_real_escape_string($conn, $_GET["id"]);
  $user = new User($userid);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <?php include 'css/css.html'; ?>
  <script src = "js/like.js"></script>
</head>

<body>
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

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="myNavbar">
      <p class="navbar-text">
       Logged in as <a href="profile.php?id=<?php echo $_SESSION["userid"] ?>"><b><?php echo "@".$_SESSION["username"]; ?></b></a></p>

     

      <ul class="nav navbar-nav navbar-right">
        <li class = "active"><a href="profile.php?id=<?php echo $_SESSION["userid"] ?>">Profile</a></li>
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

<div id= "main-content" class="container-fluid">

<div class="row">
    <div class="col-md-3">
    <div class="panel panel-success">
        <div class="panel-heading text-center"><?php echo "@".$user->username; ?></div>
        <div class="panel-body"> 
        <form action="followuser.php" method="post">
          <input type="hidden" name="userid" value="<?php echo $userid ?>" />
          <p id = "posting">
            <?php echo $user->getNumFollowing(); ?> Following |
            <?php echo $user->getNumFollowers(); ?> Followers
          </p>
          <?php $user->getFollowButton(); ?>
        </form>  
          <br>
         

        </div>
      </div>
    
    </div><!-- End of 1st col-->

    <div class="col-md-5">
    
        <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid) : ?>
        <div class="panel panel-success">
          <form action="addcomment.php" method="post">
            <textarea class="form-control" rows="3" name="comment" placeholder = "Share something with your fellow snakes..." onkeyup="count_down(this);"></textarea>
            <span class="text-muted pull-right" id="count2">200</span>
            <br>
            <input id = "hissButton" type="submit" value="HISS" />
            <br />
            <br />
          </form>
          </div>
        <?php endif; ?>
      
        <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid) : ?>
        <div class="panel panel-success">

        <?php $user->getFeed();?>
        </div>
        <?php endif; ?>

        <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] != $userid) : ?>
        <div class="panel panel-success">
       
        <div class="panel-heading">
        @
        <?php 
        $sql = "SELECT * FROM users WHERE userid='$userid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo $row['username']; 
        ?>'s Hisses
        </div>
        <?php $user->getPosts();?>
        
        </div>
        <?php endif; ?>

        <?php
          $sql = "SELECT * FROM user";
          $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)> 0){
            while($row = mysqli_fetch_array($result)){
              $id = $row['id'];
              $sqlImg = "SELECT * FROM profileimg WHERE userid = 'id'";
              $resultImg = mysqli_query($conn, $sqlImg);
                while($rowImg = mysql_fetch_assoc($resultImg)){
                    echo "<div>";
                        if($rowImg['status']== 0){
                          echo "<img src= 'images/profile".$id.".jpg'>";
                        }else{
                          echo "<img src= 'images/snake.png'>";
                        }
                        echo $row['username'];
                    echo "</div>";
                }
            }
          }else{
            echo "No Users currently!";
          }
          if(isset($_SESSION['id'])){
            echo  "<form action='fileUpload.php' method='post' enctype='multipart/form-data'>
                      <input type='file' name= 'image'>
                      <input type='submit' name='upload' value='Upload Image'>
                  </form>";
          }
          ?>

    </div><!--End of 2nd Col-->

    <div class="col-md-4"> 
    <div class="panel panel-success">
        <div class="panel-heading">Who to Follow</div>
        <div class="panel-body"> <?php $user->getOtherUsers(); ?> </div>
      </div>

    </div><!-- End of 3rd col-->

</div> <!--End of row -->
</div> <!-- End of container-->

  
  
  <footer class="footer bg-dark">
        <div class="container">
            <p class="m-0 text-center">Copyright &copy;Hisser Sharing</p>
        </div>
        <!-- /.container -->
    </footer> 
<script>     
        function count_down(obj) {
             
            var element = document.getElementById('count2');
             
            element.innerHTML = 200 - obj.value.length;
             
            if (200 - obj.value.length < 0) {
                element.style.color = 'red';
             
            } else {
                element.style.color = '#1ab188';
            }
             
        }

</script>
</body>

</html>
<?php endif; ?>
<?php $conn->close(); ?>
