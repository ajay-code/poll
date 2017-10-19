<?php
include 'includes.php';

$admin = new Admin();
$admin->redirectIfNotLoggedIn();

$admin->deleteOption($_GET['optionID']);

header('LOCATION: home.php');