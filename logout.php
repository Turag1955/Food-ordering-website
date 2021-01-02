<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
redirect('shop');
