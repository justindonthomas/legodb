<?php
/*
 * Login script.
 */

include_once '../../config/configs.php';
include_once '../../static/php/DBConnection.php';
session_start();

if(!empty($_POST)) {
    $dbConnection = new DBConnection($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    $username = $_POST['u_name'];

    $queryString = "SELECT user_id, is_admin FROM users WHERE username = ?";
    $types = 's';
    $vars = array($username);
    $result = $dbConnection->executePreparedSelect($queryString, $types, $vars, $id, $isAdmin);

    if (!$result->fetch()) {
        $queryString = "SELECT password FROM passwords WHERE user_id = ?";
        $vars = array($id);
        $result = $dbConnection->executePreparedSelect($queryString, 's', $vars, $password);
        $result->fetch();
        if (password_verify($_POST['u_pass'], $password)) {
            $_SESSION['s_user'] = $_POST['u_name'];
            $_SESSION['s_id'] = $id;
            $_SESSION['is_admin'] = $isAdmin;
            header('Location: ../landingPage.php');
        } else {
            header('Location: ../../index.html');
        }
    } else {
        header('Location: ../../index.html');
    }
} else {
    header('Location: ../../index.html');
}



?>