<?php
/**
 * Add a user and password to the database.
 */

include_once '../../static/php/DBConnection.php';
include_once '../../config/configs.php';

if(!empty($_POST)) {

    $dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    $uname = $_POST['name'];
    $uemail = $_POST['email'];
    $upassword = password_hash($_POST['passwordIn'], PASSWORD_DEFAULT);
    echo $uname." ".$uemail." ".$upassword."<br>";

    $queryString = "INSERT INTO users (username, email) VALUES (?,?)";

    $dbConnection->executePreparedStatement($queryString, 'ss', $uname, $uemail);

    if ($dbConnection->getErrno()) {
        die("Error adding user: ".$dbConnection->getErrno().":".$dbConnection->getError());
    }

    $queryString = "SELECT user_id FROM users WHERE username = ? LIMIT 1";
    $result = $dbConnection->executePreparedSelect($queryString, 's', array($uname), $uidNum);
    $result->fetch();

    $queryString = "INSERT INTO passwords (user_id, password) VALUES(?, ?)";
    $dbConnection->executePreparedStatement($queryString, 'ss', $uidNum, $upassword);

    if ($dbConnection->getErrno()) {
        die("Error adding user.");
    }

    echo "Success";
}

?>
