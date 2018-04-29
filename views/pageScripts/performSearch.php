<?php
/**
 * Connect to the database and perform a search given the parameters in the post.
 */
include_once '../../config/configs.php';
include_once '../../static/php/DBConnection.php';
session_start();

$dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

$searchFor = $_POST['searchfor'];
$searchBy = $_POST['searchby'];
$colorTerm = $_POST['colorTerms'];
$searchTerms = $dbConnection->getEscapedString($_POST['searchterms']);

$searchResults = performSearch($dbConnection, $searchFor, $searchBy, $searchTerms, $colorTerm, $IMG_PATH_ROOT);

echo $searchResults;

/**
 * Perform a search based on parameters provided in the POST.
 * @param DBConnection $dbConn mysqli connection to the database.
 * @param string $searchFor Table to search in.
 * @param string $searchBy Method to search by.
 * @param string $searchTerms Provided string to search on.
 * @param string $colorTerm Color search term index field value.
 * @param string $pathRoot Base of path to images.
 * @return string An html table containing the search results.
 */
function performSearch(DBConnection $dbConn, string $searchFor, string $searchBy, string $searchTerms,
                        string $colorTerm, string $pathRoot) {
    switch ($searchFor) {
        case 'minifig':
            return minifigSearch($dbConn, $searchBy, $searchTerms);
        case 'set':
            return setSearch($dbConn, $searchBy, $searchTerms);
        case 'my favorites':
            return favoritesSearch($dbConn, $_SESSION['s_id']);
        case 'set inventory':
            return setInventorySearch($dbConn, $searchBy, $searchTerms);
        case 'minifig inventory':
            return minifigInventorySearch($dbConn, $searchBy, $searchTerms);
        case 'user':
            return searchUser($dbConn, $searchBy, $searchTerms);
        case 'image':
            return searchImage($dbConn, $searchTerms, $colorTerm, $pathRoot);
        default:
            return '';
    }
}

function searchImage(DBConnection $dbConn, string $searchTerms, string $colorTerm, string $pathRoot) {
    //get colorId
    $queryString = "SELECT color_id FROM colors WHERE color_name = ?";
    $result = $dbConn->executePreparedSelect($queryString, 's', array($colorTerm), $colorId);
    $result->fetch();

    $queryString = "SELECT image FROM part_images WHERE part_number = ? AND color_id = ?";
    $result = $dbConn->executePreparedSelect($queryString, 'si', array($searchTerms, $colorId), $pathEnd);
    $result->fetch();
    $fullPath = $pathRoot.$pathEnd;
    return '<img src="'.$fullPath.'"  alt="image not found." class="center">';
}

function searchUser(DBConnection $dbConn, string $searchBy, string $searchTerms) {
    $columnNames = array('username', 'email', 'is admin');
    $queryBase = "SELECT username, email, is_admin FROM users";
    switch($searchBy) {
        case 'user name':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'username');
        case 'email':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'email');
        case 'all':
            return buildTableString($dbConn->executeSimpleQuery($queryBase), $columnNames);
        default:
            return '';
    }
}
/**
 * Decides what to do during a search on the minifigs table.
 * @param DBConnection $dbConn mysqli database connection.
 * @param string $searchBy column to search on.
 * @param string $searchTerms Provided term to search on.
 * @return string An html table containing the search results.
 */
function minifigSearch(DBConnection $dbConn, string $searchBy, string $searchTerms) {
    $columnNames = array('number', 'name', 'theme', 'year released');
    $queryBase = "SELECT minifig_part_number, description, theme_name, year_released FROM minifigs 
                  INNER JOIN themes ON minifigs.theme_id = themes.theme_id";
    switch ($searchBy) {
        case 'description':
            return descriptionSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'description');
        case 'theme':
            return descriptionSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'theme_name');
        case 'year':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'year_released');
        case 'part id':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'minifig_part_number');
        default:
            return '';
    }
}

/**
 * Decides what to do during a search on the sets table.
 * @param DBConnection $dbConn mysqli database connection.
 * @param string $searchBy Column to search on.
 * @param string $searchTerms Provided term to search for.
 * @return string HTML table with search results.
 */
function setSearch(DBConnection $dbConn, string $searchBy, string $searchTerms) {
    $columnNames = array('set number', 'name', 'theme', 'year released');
    $queryBase = "SELECT set_num, set_name, theme_name, year_released FROM sets
                  INNER JOIN themes ON sets.theme_id = themes.theme_id";

    switch ($searchBy) {
        case 'description':
            return descriptionSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'set_name');
        case 'theme':
            return descriptionSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'theme_name');
        case 'year':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'year_released');
        case 'part id':
            return strEquivalenceSearch($dbConn, $queryBase, $searchTerms, $columnNames, 'set_num');
        default:
            return '';
    }
}

/**
 * Get the part inventory for a set.
 * @param DBConnection $dbConn mysqli connection.
 * @param string $searchBy which term to search on, name or number.
 * @param string $searchTerms Term to match when searching.
 * @return string html table representing the search results.
 */
function setInventorySearch(DBConnection $dbConn, string $searchBy, string $searchTerms) {
    $columnNames = array('part number', 'part description', 'color', 'quantity', 'is spare');
    $whereColumn = ' set_num = ';
    $param = $whereColumn."'".$searchTerms."')";
    $queryBase = "SELECT parts.part_number, part_name, color_name, quantity, is_spare_part FROM set_contents
                  INNER JOIN colors ON set_contents.color_id = colors.color_id
                  INNER JOIN parts ON set_contents.part_number = parts.part_number
                  WHERE set_id IN (SELECT set_id FROM sets WHERE ";
    $queryString = $queryBase.$param;
    //return $queryString;
    return buildTableString($dbConn->executeSimpleQuery($queryString), $columnNames);
}

function minifigInventorySearch(DBConnection $dbConn, string $searchBy, string $searchTerms) {
    $columnNames = array('part number', 'part description');

    $whereColumn = ' minifig_part_number = ';
    $param = $whereColumn."'".$searchTerms."')";
    $queryBase = "SELECT parts.part_number, part_name FROM minifig_contents
                  INNER JOIN minifigs ON minifig_contents.minifig_id = minifigs.minifig_id
                  INNER JOIN parts ON minifig_contents.part_number = parts.part_number
                  WHERE minifigs.minifig_id = (SELECT minifig_id FROM minifigs WHERE ";
    $queryString = $queryBase.$param;
    return buildTableString($dbConn->executeSimpleQuery($queryString), $columnNames);
}
/**
 * Get the current user's favorite sets.
 * @param DBConnection $dbConn Mysqli db connection
 * @param string $userId User id from the session object.
 * @return string Html table representing search results.
 */
function favoritesSearch(DBConnection $dbConn, string $userId) {
    $columnNames = array('set number', 'name', 'theme', 'year released', 'comment');
    $queryString = "SELECT set_num, set_name, theme_name, year_released, comment FROM sets 
                    INNER JOIN themes ON sets.theme_id = themes.theme_id
                    INNER JOIN favorite_sets ON sets.set_id = favorite_sets.set_id
                    WHERE favorite_sets.user_id = ".$userId;
    return buildTableString($dbConn->executeSimpleQuery($queryString), $columnNames);
}

/**
 * Perform a search on a given values equivalence in a given column (WHERE clause uses =).
 * @param DBConnection $dbConn Mysqli connection.
 * @param string $queryBase First part of the query string (before the where clause).
 * @param string $searchTerms Term to compare to.
 * @param array $columnNames Column names to use in the html table.
 * @param string $matchColName column name to match on.
 * @return string html table containing the search results.
 */
function strEquivalenceSearch(DBConnection $dbConn, string $queryBase, string $searchTerms, array $columnNames,
                              string $matchColName) {
    $param = "'".$searchTerms."'";
    $queryString = $queryBase.' WHERE '.$matchColName.' = '.$param;
    $result = $dbConn->executeSimpleQuery($queryString);
    return buildTableString($result, $columnNames);
}

/**
 * Perform a search on a description or name column.
 * @param DBConnection $dbConn mysqli connection.
 * @param string $queryBase The base of the query (No where clause).
 * @param string $searchTerms Provided search terms.
 * @param array $columnNames Array of column names to use for building the html table.
 * @param string $descColName The name of the column that holds the name or description.
 * @return string An html table containing the search results.
 */
function descriptionSearch(DBConnection $dbConn, string $queryBase, string $searchTerms, array $columnNames,
                           string $descColName) {
    $param = "'%".$searchTerms."%'";
    $queryString = $queryBase.' WHERE '.$descColName.' LIKE '.$param;
    $result = $dbConn->executeSimpleQuery($queryString);
    return buildTableString($result, $columnNames);
}

/**
 * Build an html table of search results.
 * @param mysqli_result $result results of a query.
 * @param array $columnNames column names to be used in the results table.
 * @return string An html string representing a table with search results.
 */
function buildTableString(mysqli_result $result, array $columnNames) {
    $tableString = '<table><tr>';
    foreach ($columnNames as $columnName) {
        $tableString = $tableString.'<th>'.$columnName.'</th>';
    }
    $tableString = $tableString.'</tr>';
    while($row = $result->fetch_row()) {
        $tableString = $tableString.'<tr>';
        foreach($row as $value) {
            $tableString = $tableString.'<td>'.$value.'</td>';
        }
        $tableString = $tableString.'</tr>';
    }
    $tableString = $tableString.'</table>';
    return $tableString;
}
?>