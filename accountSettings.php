<?php
/**
 * Account
 *  Shows options for account deletion and password changing
 */
session_start();
include 'database.php';
include 'user.php';


if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your Account page!";
  header("location: error.php");    
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
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
      <a class="navbar-brand" href="homepage.php?id=<?php echo $_SESSION["userid"] ?>">
                        <img id="brand-image" src="images/snake.png" alt="snake">
                        Hisser - A Sharing Site for Snakes 
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="myNavbar">
      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php?id=<?php echo $_SESSION["userid"] ?>">Profile</a></li>
        <li class="dropdown active">
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
    <div class="container-fluid text-center">

        <div class="row">
      
            <div class="col-lg-2">
                
            </div>
            <div class="col-lg-8">
            <div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#changePass">Change Password</a></li>
        <li class="tab"><a href="#delAcc">Delete Account</a></li>
      </ul>
      
      <div class="tab-content">

         <div id="changePass">   
          <h1>Change your Password</h1>
          
          <form action="newPassword.php" method="post" autocomplete="off">
          
            <div class="field-wrap">
            <label>
              Old Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="oldPass"/>
          </div>
          
          <div class="field-wrap">
            <label>
              New Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="newPass"/>
          </div>
          
          <button class="button button-block" name="resetPass" />Update Password</button>
          
          </form>

        </div>
          
        <div id="signup">   
          <h1>Become a Snake for Free!</h1>
          
          <form action="index.php" method="post" autocomplete="off">
          
        
            <div class="field-wrap">
              <label>
                Username<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='username' />
            </div>
        
          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='email' />
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name='password'/>
          </div>
          
          <button type="submit" class="button button-block" name="register" />Register</button>
          
          </form>

        </div>  
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
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