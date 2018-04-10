<?php
/*
 * Login script.
 */

include '../../static/php/DBConnection.php';
session_start();

if(!empty($_POST)) {
    $username = $_POST['u_name'];

    //$queryString = "SELECT id, password FROM registered_users WHERE `name` = ";
    $queryString = "SELECT uId, pWordHash FROM loginTable WHERE uId = (
                          SELECT uId FROM userNames WHERE uName = ?)";
    $types = 's';
    $vars = array($username);
    $dbConnection = new DBConnection();
    $result = $dbConnection->executePreparedSelect($queryString, $types, $vars, $id, $password);
    $result->fetch();

    //echo $_POST['passwordIn'];
    ///echo $password;
    if(password_verify($_POST['u_pass'], $password)) {
        $_SESSION['s_user'] = $_POST['u_name'];
        $_SESSION['s_id'] = $id;
        header('Location: ../mySchedule.php');
    } else {
        echo 'Invalid username or password';
    }
} else {
    echo 'Invalid username or password';
}



?>