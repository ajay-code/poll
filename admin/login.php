<?php
include 'includes.php';

$admin = new Admin();
$username = $_POST['username'];
$password = $_POST['password'];
if($admin->login($username, $password)){
    if(isset($_SESSION['errors'])) unset($_SESSION["errors"]);
    if(isset($_SESSION['old'])) unset($_SESSION["old"]);
    header('LOCATION: home.php');
}else{
    $_SESSION['errors'] = 'Username or password is worng';
    $_SESSION['old'] = [
        'username' => $username,
        'remember' => isset($_POST['remember']) ? true : false
     ];
    header('LOCATION: index.php');
}
