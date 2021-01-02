<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';

//prx($_POST);
$type = get_safe_value($conn, $_POST['type']);
$dish_details_id = get_safe_value($conn, $_POST['attr']);

$cartarr = [];

if ($type == 'add') {
    $qty = get_safe_value($conn, $_POST['qty']);
    $total_amount = 0;
    get_insert_cart_data($dish_details_id, $qty);
    $get_cart_data = get_cart_data();
    foreach ($get_cart_data as $val) {
        $total_amount = ($total_amount + ($val['qty'] * $val['price']));
    }
    $get_addToCart = get_addToCart($dish_details_id);
    $dishDetailsId = $get_addToCart['id'];
    $dish = $get_addToCart['dish'];
    $price = $get_addToCart['price'];
    $image = $get_addToCart['image'];

    $total_cart = count($get_cart_data);
    $cartarr = ['totalcart' => $total_cart, 'totalamount' => $total_amount, 'dish' => $dish, 'price' => $price, 'image' => $image, 'dish_details_id' => $dishDetailsId];
    echo json_encode($cartarr);
}
if ($type == 'cart_delete') {
    $total_amount = 0;
    delete_cart($dish_details_id);
    $get_cart_data = get_cart_data();
    foreach ($get_cart_data as $val) {
        $total_amount = ($total_amount + ($val['qty'] * $val['price']));
    }
    $total_cart = count($get_cart_data);
    $cartarr = ['totalcart' => $total_cart, 'totalamount' => $total_amount];
    echo json_encode($cartarr);
}
if ($type == 'qty_update') {
    
}
?>