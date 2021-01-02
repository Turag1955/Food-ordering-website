<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
$arr = [];
$rating = get_safe_value($conn, $_POST['rate']);
$dish_details_id = get_safe_value($conn, $_POST['dish_details_id']);
$order_id = get_safe_value($conn, $_POST['order_id']);
$uid = $_SESSION['user_id'];

    $coupon_query = mysqli_query($conn, "insert into rating (user_id,order_id,dish_details_id,rating) values('$uid','$order_id','$dish_details_id','$rating') ");

?>