<?php
require_once '../config/function.php';
session_start();
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
redirect('login.php');
