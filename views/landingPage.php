<?php
include_once "pageScripts/LandingPageBuilder.php";
session_start();
if (!isset($_SESSION['s_user'])) {
      header('location: ../index.html');
}
$pageBuilder = new LandingPageBuilder($_SESSION);

?>
<!DOCTYPE html>
<html>
  <head>
      <title>Your Home Page</title>
      <link href="../static/css/standard_styles.css" rel="stylesheet">
  </head>
  <body>
  <?php
  echo $pageBuilder->getTopBar();
  echo $pageBuilder->getSearchOptions();
  ?>


  Is admin: <?php if ($_SESSION['is_admin'] == 1) {
      echo "Yes<br>";
      } elseif ($_SESSION['is_admin'] == 0) {
      echo "No.<br>";
      } else {
      echo "I don't know<br>";
      } ?>
  </body>
</html>

