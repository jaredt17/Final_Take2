<?php
/**
 * Account
 *  Shows options for account deletion and password changing
 */
session_start();
include 'database.php';
include 'user.php';

//
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in before viewing your Account page!";
  header("location: error.php");    
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="images/snake.png" type="image/x-icon" />
  <title>Account Settings</title>
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
        <li class="tab"><a href="#delete">Delete Account</a></li>
      </ul>
      
      <div class="tab-content">

         <div id="changePass">   
          <h1>Change your Password</h1>
          
          <form action="newPassword.php" method="post" autocomplete="off">
          
          <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="username" id="username"/>
          </div>

            <div class="field-wrap">
            <label>
              Old Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="oldPass" id="oldPass"/>
          </div>
          
          <div class="field-wrap">
            <label>
              New Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="newPass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id ="psw"/>
          </div>
          <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
          </div>
          <button class="button button-block" name="resetPass" />Update Password</button>
          
          </form>

        </div>
          
        <div id="delete">   
          <h1>Delete Your Account :'(</h1>
          
          <form action="deleteAcc.php" method="post" autocomplete="off">
          
        
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
              Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name='password'/>
          </div>
          
          <button type="submit" class="button button-block" name="delete" />Delete Account! (CANNOT BE UNDONE)</button>
          
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
        <script>     
      var myInput = document.getElementById("psw");
      var letter = document.getElementById("letter");
      var capital = document.getElementById("capital");
      var number = document.getElementById("number");
      var length = document.getElementById("length");

      // When the user clicks on the password field, show the message box
      myInput.onfocus = function() {
          document.getElementById("message").style.display = "block";
      }

      // When the user clicks outside of the password field, hide the message box
      myInput.onblur = function() {
          document.getElementById("message").style.display = "none";
      }

      // When the user starts to type something inside the password field
      myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {  
          letter.classList.remove("invalid");
          letter.classList.add("valid");
        } else {
          letter.classList.remove("valid");
          letter.classList.add("invalid");
        }
        
        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {  
          capital.classList.remove("invalid");
          capital.classList.add("valid");
        } else {
          capital.classList.remove("valid");
          capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {  
          number.classList.remove("invalid");
          number.classList.add("valid");
        } else {
          number.classList.remove("valid");
          number.classList.add("invalid");
        }
        
        // Validate length
        if(myInput.value.length >= 8) {
          length.classList.remove("invalid");
          length.classList.add("valid");
        } else {
          length.classList.remove("valid");
          length.classList.add("invalid");
        }
      }
</script>
</body>
</html>