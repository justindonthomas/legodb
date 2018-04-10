<?php


session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Your Home Page</title>
  </head>
  <body>
    <div id="profile">
      <b id="welcome">Logged in as: <i><?php echo $_SESSION['s_user']; ?></i></b>
    </div>
    Login successful <br>
  Is admin: <?php echo $_SESSION['is_admin']; ?>
  </body>
</html>

