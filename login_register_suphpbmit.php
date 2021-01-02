<?php

require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';


$type = get_safe_value($conn, $_POST['type']);
if ($type == 'register') {

    $name = get_safe_value($conn, $_POST['user-name']);
    $password = get_safe_value($conn, $_POST['user-password']);
    $email = get_safe_value($conn, $_POST['user-email']);
    $mobile = get_safe_value($conn, $_POST['user-mobile']);
    $newpassword = password_hash($password, PASSWORD_BCRYPT);

    $check_row = mysqli_num_rows(mysqli_query($conn, "select * from users where status = 1 and email = '$email' "));
    if ($check_row > 0) {
        $arr = ['status' => 'error', 'msg' => 'this email aready exits', 'field' => 'email_error'];
    } else {
        $random_str = random_str();
        $referral_code =  random_str();
        $subject = 'Varify Your Email';
        $html = SITE_PATH . "varify?id=" . $random_str;
        mail($email, $subject, $html);
        if(isset($_SESSION['from_referral_code'] ) && $_SESSION['from_referral_code'] != '' ){
            $from_referral_code = $_SESSION['from_referral_code'];
        }else{
            $from_referral_code = '';
        }
        $users_query = mysqli_query($conn, "insert into users (name,email,mobile,password,random_str,referral_code,from_referral_code,status) values('$name','$email','$mobile','$newpassword','$random_str','$referral_code','$from_referral_code','1') ");
        
        $uid = mysqli_insert_id($conn);
        $getSetting = getSetting();
        $wallet_amt = $getSetting['wallet_amt'];
        $insertWalletData = insertWalletData($uid, $wallet_amt, 'in', 'Register');
        unset($_SESSION['from_referral_code']);
        $arr = ['status' => 'success', 'msg' => 'Register success,please check your email for varifay', 'field' => 'success_field'];
        
    }
    echo json_encode($arr);
}
if ($type == "login") {
    $password = get_safe_value($conn, $_POST['password']);
    $email = get_safe_value($conn, $_POST['email']);
    $checkout_login = get_safe_value($conn, $_POST['checkout_login']);
    $sql = "select * from users where status = 1 and email = '$email' ";
    $query = mysqli_query($conn, $sql);
    $check_row = mysqli_num_rows($query);
    if ($check_row > 0) {
        $assoc = mysqli_fetch_assoc($query);
        $hasspassword = $assoc['password'];
        $status = $assoc['status'];
        $email_varify = $assoc['email_varify'];
        if ($email_varify == 1) {
            if ($status == 1) {
                if (password_verify($password, $hasspassword)) {
                    $_SESSION['user_id'] = $assoc['id'];
                    $_SESSION['user_name'] = $assoc['name'];
                    $_SESSION['user_email'] = $assoc['email'];
                    $_SESSION['user_mobile'] = $assoc['mobile'];


                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        foreach ($_SESSION['cart'] as $key => $val) {
                            $get_insert_cart_data = get_insert_cart_data($key, $val['qty']);
                        }
                    }
                    if ($checkout_login == 'checkout_login') {
                        $arr = ['status' => 'success', 'msg' => 'checkout_login'];
                    } else {
                        $arr = ['status' => 'success', 'msg' => ' ', 'field' => 'login_error'];
                    }
                } else {
                    $arr = ['status' => 'error', 'msg' => 'Password is incorrect', 'field' => 'login_error'];
                }
            } else {
                $arr = ['status' => 'error', 'msg' => 'Your id is Deactive', 'field' => 'login_error'];
            }
        } else {
            $arr = ['status' => 'error', 'msg' => 'Please Email Id Varify', 'field' => 'login_error'];
        }
    } else {
        $arr = ['status' => 'error', 'msg' => 'Invalid login information ', 'field' => 'login_error'];
    }
    echo json_encode($arr);
}

if ($type == "forgot_password") {
    $email = get_safe_value($conn, $_POST['email']);
    $sql = "select * from users where   email = '$email' ";
    $query = mysqli_query($conn, $sql);
    $check_row = mysqli_num_rows($query);
    if ($check_row > 0) {
        $assoc = mysqli_fetch_assoc($query);
        $id = $assoc['id'];
        $status = $assoc['status'];
        $email_varify = $assoc['email_varify'];
        if ($email_varify == 1) {
            if ($status == 1) {
                $random_password = rand(11111, 99999);
                $newpassword = password_hash($random_password, PASSWORD_BCRYPT);
                $update_password = mysqli_query($conn, "update users set password = '$newpassword' where id = $id ");
                $html = 'Your New Passwor -' . $random_password;
                mail($email, 'Forgot Password', $html);
                $arr = ['status' => 'success', 'msg' => 'Please check Your Email', 'field' => 'forgot_success'];
            } else {
                $arr = ['status' => 'error', 'msg' => 'Your id is Deactive', 'field' => 'forgot_error'];
            }
        } else {
            $arr = ['status' => 'error', 'msg' => 'Please Email Id Varify', 'field' => 'forgot_error'];
        }
    } else {
        $arr = ['status' => 'error', 'msg' => 'Invalid your Email Address ', 'field' => 'forgot_error'];
    }
    echo json_encode($arr);
}
?>