<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
$arr = [];
$coupon_code = get_safe_value($conn, $_POST['coupon_code']);


$coupon_query = mysqli_query($conn, "select * from coupon where coupon_name = '$coupon_code' and status = 1 ");
$row = mysqli_num_rows($coupon_query);
if ($row > 0) {
    $total_amount = get_safe_value($conn, $_POST['total_amount']);
    $coupon_assoc = mysqli_fetch_assoc($coupon_query);
    $name = $coupon_assoc['coupon_name'];
    $coupon_type = $coupon_assoc['coupon_type'];
    $coupon_value = $coupon_assoc['coupon_value'];
    $cat_min_value = $coupon_assoc['cat_min_value'];
    $expire_date = $coupon_assoc['expire_date'];
    $current_date = date('Y-m-d');


    if ($current_date < $expire_date) {
        if ($cat_min_value < $total_amount) {
            $final_price = 0;
            if ($coupon_type == 'parcent') {
                $parcent_price = $coupon_value / 100 * $total_amount;
                $final_price = $total_amount - $parcent_price;
            }
            if ($coupon_type == 'fixed') {
                $final_price = $coupon_value - $total_amount;
            }
            $_SESSION['coupon_code'] = $name;
            $_SESSION['discount_price'] = $final_price;
            $arr = ['status' => 'success', 'msg' => 'Coupon Apply ', 'discount_price' => $final_price];
        } else {
            $arr = ['status' => 'error', 'msg' => 'Total price more then ' . $cat_min_value . ' Tk'];
        }
    } else {
        $arr = ['status' => 'error', 'msg' => 'Coupon date expired'];
    }
} else {
    $arr = ['status' => 'error', 'msg' => 'Coupon Code Invalid'];
}

echo json_encode($arr);
?>