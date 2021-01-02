<?php
require_once './header.php';
require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';




if (!isset($_GET['id'])) {
    redirect('shop');
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $str_random = get_safe_value($conn, $_GET['id']);
    $query = mysqli_query($conn, "select * from users where random_str = '$str_random' ");
    $check_row = mysqli_num_rows($query);
    if ($check_row > 0) {
        $query = mysqli_query($conn, "update users set  email_varify = 1  where random_str = '$str_random' ");
        $msg = 'Email id is Varify';
        $getSetting = getSetting();
        $referral_amt = $getSetting['referral_amt'];
        if ($referral_amt > 0) {
            $res = mysqli_query($conn, "select from_referral_code from users where random_str = '$str_random' ");
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $from_referral_code = $row['from_referral_code'];
                $result = mysqli_fetch_assoc(mysqli_query($conn, "select id from users where referral_code = '$from_referral_code' "));
                $uid = $result['id'];
                insertWalletData($uid, $referral_amt, 'in', 'Referral Bounus');
            }
        }
    } else {
        //redirect('shop');
        $msg = 'invalid varify';
    }
} else {
    $msg = 'Please Check your email address';
}
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
<?php
if (isset($msg)) {
    ?>
                        <div class="alert alert-success"><?= $msg ?></div>
                        <?php
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>