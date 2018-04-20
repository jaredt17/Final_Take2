<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="images/snake.png" type="image/x-icon" />
  <meta charset="UTF-8">
  <title>See you next time!</title>
  <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">
          <h1>Thanks for stopping by</h1>
              
          <p><?= 'You have been logged out!'; ?></p>
          
          <a href="index.php"><button class="button button-block"/>Home</button></a>

    </div>
    <footer class="footer bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy;Hisser Sharing</p>
        </div>
        <!-- /.container -->
    </footer> 
</body>
</html>
