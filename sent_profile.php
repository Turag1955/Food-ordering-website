<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';


$type = get_safe_value($conn, $_POST['type']);
$arr = [];


if ($type == "update_profile") {
    $name = get_safe_value($conn, $_POST['name']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $uid = $_SESSION['user_id'];

    $sql = "update users set name = '$name', mobile = '$mobile' where id = '$uid' ";
    $query = mysqli_query($conn, $sql);
    $_SESSION['user_name'] = $name;
    $_SESSION['user_mobile'] = $mobile;
    
    $arr = ['status' => 'success', 'msg' => 'Profile Update', 'name' => ucfirst($name), 'mobile' => $mobile];
    echo json_encode($arr);
}

if ($type == "change_password") {
    $old_password = get_safe_value($conn, $_POST['password']);
    $uid = $_SESSION['user_id'];

    $sql = "select password from users where id = '$uid' ";
    $query = mysqli_query($conn, $sql);
    $assoc = mysqli_fetch_assoc($query);
    $dbpassword = $assoc['password'];

    if (password_verify($old_password, $dbpassword)) {
        $new_password = get_safe_value($conn, $_POST['confirm_password']);
        $hash_new_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_password = mysqli_query($conn, "update users set password = '$hash_new_password' where id = $uid ");
        $arr = ['type' => 'change_password', 'status' => 'success', 'msg' => 'Password Change'];
    } else {
        $arr = ['status' => 'error', 'msg' => 'your old password incorrect'];
    }
    echo json_encode($arr);
}
?>