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
  <link rel="shortcut icon" href="images/snake.png" type="image/x-icon" />
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
        <div class="panel-heading text-center">
          <p><small>Click on your profile picture to change it!</small></p>
        <?php 
        $sqlImg = "SELECT * FROM profileimg WHERE userid = '$userid'";
        $resultImg = mysqli_query($conn, $sqlImg);
        while($rowImg = mysqli_fetch_assoc($resultImg)){
            echo "<div class='profileimage'>";
            if($rowImg['status'] == 0){
              echo "<a href = 'accountSettings.php'>";
              echo "<img src = 'uploads/".$userid.".jpg' alt = 'uid.ext'>";
              echo "</a>";
            }else{
              echo "<a href = 'accountSettings.php'>";
              echo "<img src = 'uploads/profiledefault.jpg' alt = 'defaultProf.ext'>";
              echo "</a>";
            }
            echo "</div>";
        }
        ?>
        <?php echo "@".$user->username; ?>
      
      </div>
        <div class="panel-body"> 
        <form action="followuser.php" method="post">
          <input type="hidden" name="userid" value="<?php echo $userid ?>" />
          <p id = "posting">
            <?php $user->getCity();?>
            <?php echo $user->getNumFollowing(); ?> Following |
            <?php echo $user->getNumFollowers(); ?> Followers
          </p>
          <?php $user->getFollowButton(); ?>
        </form>  
          <br>
         <!-- PLACE PROFILE IMAGE HERE -->

        </div>
      </div>
              <!--IMAGE CONTENT__________________________________________________________________________________________ -->
      <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid) : ?>


<div class="panel panel-success">
<?php $user->getMentions(); ?>



</div>


      <?php endif; ?>
         <!--_____________________________________________________________________________________________________ -->


    </div><!-- End of 1st col-->

    <div class="col-md-5">
    
        <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid) : ?>
        <div class="panel panel-success">
        <div class="panel-heading">
          <form action="addcomment.php" method="post">
            <textarea class="form-control" rows="3" name="comment" placeholder = "Share something with your fellow snakes..." onkeyup="count_down(this);"></textarea>
            <span class="text-muted pull-right" id="count2">200</span>
            <br>
            <input id = "hissButton" type="submit" value="HISS" />
          </form>
          </div>
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
        
        while($row = $result->fetch_assoc())
        {
          echo $row['username']; 
        }
        ?>'s Hisses
        </div>
        <?php $user->getPosts();?>
        
        </div>
        <?php endif; ?>

       
    </div><!--End of 2nd Col-->

    <div class="col-md-4"> 
      
    <div class="panel panel-success">
        <div class="panel-heading">Search for a user or post!
        <!-- SEARCH BAR HERE!?-->
        <form action="search.php" method="POST"> 
        <input type = "text" name = "search" id="searchbar" onclick ="alertfunc()" placeholder"Search">
        <input name = "submit-search" id = "submit-search" type="submit" value="Search" />
        </div>
        </form>
      </div>




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
     <!-- Bootstrap core JavaScript -->
     <script src="css/jquery/jquery.min.js"></script>
        <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="js/index.js"></script>
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

      var isClicked = false;
      function alertfunc() {
      if(isClicked === false)
      {
        confirm("If you are searching for a user do not include the '@' symbol. Thanks!");
        isClicked = true;
      }
     

      }


</script>


</body>

</html>
<?php endif; ?>
<?php $conn->close(); ?>
