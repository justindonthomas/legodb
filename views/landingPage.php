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
      <script type="text/javascript" src="../lib/jquery-3.3.1.min.js"></script>
  </head>
  <body>
  <?php
  echo $pageBuilder->getTopBar();
  ?>
  <form id="searchForm" action="pageScripts/performSearch.php">
      Search For:
      <select id=searchFor onchange="createSearchByDropdown(this, document.getElementById('searchBy'))">
          <?php
          echo $pageBuilder->getSearchOptions();
          ?>
      </select>
      Search By:
      <select id="searchBy">
      </select>
      Search term:<input type="text" id="searchTerms">
      <input type="submit">
  </form>
  <script type="text/javascript" src="../static/js/searchController.js"></script>
  <script>

  </script>

  </body>
</html>
