<?php
include_once '../../config/configs.php';
include_once '../../static/php/DBConnection.php';

$dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

$searchFor = $_POST['searchfor'];
$searchBy = $_POST['searchby'];
$searchTerms = $dbConnection->getEscapedString($_POST['searchterms']);

$tableName = getTableName($searchFor);
$condition = getColumn($tableName, $searchBy);

$queryString = "SELECT * FROM $tableName WHERE $condition = '$searchTerms'";
$result = $dbConnection->executeSimpleQuery($queryString);
echo json_encode($result->fetch_assoc());

function getTableName($searchFor) {
    switch ($searchFor) {
        case 'minifig':
            return 'minifigs';
        case 'set':
            return 'sets';
        case 'part':
            return 'parts';
        case 'user':
            return 'users';
        default:
            return '';
    }
}

function getColumn($tableName, $searchBy) {
    switch ($tableName) {
        case 'minifigs':
            switch($searchBy) {
                case 'part id':
                    return 'minifig_part_id';
                case 'description contains':
                    return 'description';
                default:
                    return '';
            }
        case 'sets':
            switch ($searchBy) {
                case 'part id':
                    return 'set_num';
                case 'description contains':
                    return 'set_name';
                default:
                    return '';
            }
        case 'parts':
            switch ($searchBy) {
                case 'part id':
                    return 'part_number';
                case 'description contains':
                    return 'part_name';
                default:
                    return '';
            }
        case 'users':
            switch ($searchBy) {
                case 'user name':
                    return 'username';
                case 'email':
                    return 'email';
                default:
                    return '';
            }
        default:
            return '';
    }
}
?>