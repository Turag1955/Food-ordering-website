<?php
require_once '../config/function.php';
session_start();
unset($_SESSION['DELIVERY_BOY_LOGIN']);
unset($_SESSION['DELIVERY_BOY_ID']);
unset($_SESSION['DELIVERY_BOY_NAME']);
redirect('login.php');
