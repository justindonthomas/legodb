<?php
/**
 * Main page for accessing the database.
 */
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
      <title>LEGO Visual Database</title>
      <link href="../static/css/standard_styles.css" rel="stylesheet">
      <script type="text/javascript" src="../lib/jquery-3.3.1.min.js"></script>
  </head>
  <body>
  <?php
  echo $pageBuilder->getTopBar();
  ?>
  <fieldset class="blueback">
      <h2>Add a Favorite Set</h2>
    <legend></legend>
    <form id="favoriteInput" action = "pageScripts/inputFavorites.php">
        Set number: <input type="text" name="partnum" id="partnum">
        Comment: <input type="text" name="comment" id="comment">
        <input type="submit" value="Submit">
    </form>
  </fieldset>
  <fieldset class="blueback">
      <h2>Search the Database</h2>
      <legend></legend>
    <form id="searchForm" action="pageScripts/performSearch.php">
        Search For:
        <select id=searchFor onchange="createSearchByDropdown(this, document.getElementById('searchBy'), document.getElementById('colorInput'))">
            <?php
            echo $pageBuilder->getSearchOptions();
            ?>
        </select>
        Search By:
        <select id="searchBy">
        </select><br>
        Search term:<input type="text" id="searchTerms">
        <div id="colorInput">
            Color: <input type="text" id="colorTerm">
        </div>
        <input type="submit">
    </form>
    </fieldset>
  <div id="results"></div>
  <script type="text/javascript" src="../static/js/searchController.js"></script>
  </body>
</html>
