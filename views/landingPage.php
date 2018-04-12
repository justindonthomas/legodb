<?php


session_start();

?>
<!DOCTYPE html>
<html>
  <head>
      <title>Your Home Page</title>
      <link href="../static/css/standard_styles.css" rel="stylesheet">
  </head>
  <body>
  <span class="leftalign"> Logged in as: <?php echo $_SESSION['s_user']; ?></span>
  <span class="rightalign"><a href="pageScripts/logout.php">Log Out.</a></span> <br>
  <p>Login successful <p>
  Is admin: <?php echo $_SESSION['is_admin']; ?>
  </body>
</html>

