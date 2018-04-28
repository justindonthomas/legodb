<?php
include_once "pageScripts/LandingPageBuilder.php";
include_once "../config/configs.php";
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
  <h2>Add a Favorite</h2>
  <form id="favoriteInput" action = "pageScripts/inputFavorites.php">
      Part number: <input type="text" name="partnum" id="partnum">
      Comment: <input type="text" name="comment" id="comment">
      <input type="submit" value="Submit">
  </form>
  <h2>Search the Database</h2>
  <form id="searchForm" action="pageScripts/performSearch.php">
      Search For:
      <select id=searchFor onchange="createSearchByDropdown(this, document.getElementById('searchBy'), document.getElementById('colorInput'))">
          <?php
          echo $pageBuilder->getSearchOptions();
          ?>
      </select>
      Search By:
      <select id="searchBy">
      </select>
      Search term:<input type="text" id="searchTerms">
      <div id="colorInput">
        Color: <input type="text" id="colorTerm">
      </div>
      <input type="submit">
  </form>
  <div id="results"></div>
  <script type="text/javascript" src="../static/js/searchController.js"></script>
  </body>
</html>
