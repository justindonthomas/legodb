<?php
include_once '../../config/configs.php';
include_once '../../static/php/DBConnection.php';

$dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

$searchFor = $_POST['searchfor'];
$searchBy = $_POST['searchby'];
$searchTerms = $dbConnection->getEscapedString($_POST['searchterms']);

$searchResults = performSearch($dbConnection, $searchFor, $searchBy, $searchTerms);

echo $searchResults;

/**
 * Perform a search based on parameters provided in the POST.
 * @param DBConnection $dbConn mysqli connection to the database.
 * @param string $searchFor Table to search in.
 * @param string $searchBy Method to search by.
 * @param string $searchTerms Provided string to search on.
 * @return string An html table containing the search results.
 */
function performSearch(DBConnection $dbConn, string $searchFor, string $searchBy, string $searchTerms) {
    switch ($searchFor) {
        case 'minifig':
            return minifigSearch($dbConn, $searchBy, $searchTerms);
        case 'set':
            //return $searchFor.' '.$searchBy.' '.$searchTerms;
            return setSearch($dbConn, $searchBy, $searchTerms);
        case 'part':
            return 'parts';
        case 'user':
            return 'users';
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
            //search theme
        case 'year':
            //search year.
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
            //search theme
        case 'year':
            //search year.
        default:
            return '';
    }
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