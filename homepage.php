<?php
/**
 *  Profile
 *  Shows user profile and comments
 */
session_start();
include 'database.php';
include 'user.php';
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your Home page!";
  header("location: error.php");    
}

if(isset($_GET["id"])) :
  $userid = mysqli_real_escape_string($conn, $_GET["id"]);
  $user = new User($userid);
?>
<!doctype html>
<html>
<head>
  <title>Home</title>
  <?php include 'css/css.html'; ?>
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
      <a class="navbar-brand" href="homepage.php">
                        <img id="brand-image" src="images/snake.png" alt="snake">
                        Hisser - A Sharing Site for Snakes 
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="homepage.php">Home</a></li>
        <li class = "active"><a href="profile.php">Profile</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <?php if(isset($_SESSION["userid"])) : ?>
    <p>Logged in as <a href="profile.php?id=<?php echo $_SESSION["userid"] ?>"><b><?php echo $_SESSION["username"]; ?></b></a>.
      <a href="logout.php">Logout</a></p>
  <?php endif; ?>  
  <h2><?php echo $user->username; ?></h2>
  <form action="followuser.php" method="post">
    <input type="hidden" name="userid" value="<?php echo $userid ?>" />
    <p>
      <?php echo $user->getNumFollowing(); ?> Following |
      <?php echo $user->getNumFollowers(); ?> Followers
      <?php $user->getFollowButton(); ?>
    </p>
  </form>  
  <?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] == $userid) : ?>
    <form action="addcomment.php" method="post">
      <textarea name="comment"></textarea>
      <br />
      <input type="submit" value="Submit" />
      <br />
      <br />
    </form>
  <?php endif; ?>
  <?php $user->getComments(); ?>
  <?php $user->getOtherUsers(); ?>
  <footer class="footer bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy;Hisser Sharing</p>
        </div>
        <!-- /.container -->
    </footer> 
</body>
</html>
<?php endif; ?>
<?php $conn->close(); ?>