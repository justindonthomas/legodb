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
      <!-- TODO build base page here.-->
  Is admin: <?php if ($_SESSION['is_admin'] == 1) {
      echo "Yes<br>";
      } elseif ($_SESSION['is_admin'] == 0) {
      echo "No.<br>";
      } else {
      echo "I don't know<br>";
      } ?>
  </body>
</html>

