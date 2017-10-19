<?php

include 'includes.php';

$admin = new Admin();

$admin->logout();

header('LOCATION: index.php');