<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
$arr = [];
$total_amount = get_safe_value($conn, $_POST['total_amount']);

$getSetting = getSetting();
$cart_min_amount = $getSetting['cart_min_amount'];
$cart_min_amount_msg = $getSetting['cart_min_amount_msg'];

if($total_amount>=$cart_min_amount){
      $arr = ['status' => 'success', 'msg' => 'hide'];
} else {
      $arr = ['status' => 'error', 'msg' => 'Your order not acceptable,more then amount '.$cart_min_amount.' Tk'];
}

  echo json_encode($arr);
?>