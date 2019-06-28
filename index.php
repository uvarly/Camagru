<?php

session_start();
$_SESSION['Logged_user'] = 'dio';

ini_set('display_errors', 1);
require_once 'application/bootstrap.php';