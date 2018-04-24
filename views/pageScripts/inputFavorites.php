<?php
/**
 * Input a favorite set given a set number
 */
include_once '../../config/configs.php';
include_once '../../static/php/DBConnection.php';
session_start();

$dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

$userId = $_SESSION['s_id'];
$partNum = "'".$dbConnection->getEscapedString($_POST['partnum'])."'";
$commentStr = "'".$dbConnection->getEscapedString($_POST['comment'])."'";

$queryString = "SELECT set_id FROM sets WHERE set_num = $partNum";
$result = $dbConnection->executeSimpleQuery($queryString);
$setId = $result->fetch_assoc()['set_id'];
$queryString = "INSERT INTO favorite_sets (user_id, set_id, comment)
                VALUES (?, ?, ?)";
$result = $dbConnection->executePreparedStatement($queryString, 'iss', $userId, $setId, $commentStr);
//$result = $dbConnection->executeSimpleQuery($queryString);
$userFeedback = '';
if(!$result) {
    $userFeedback = "Failed to insert favorite\n";
} else {
    $userFeedback = "Inserted favorite.";
}
echo $userFeedback;
