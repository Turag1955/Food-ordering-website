<?php
require_once './header.php';
if ($website_close == 1) {
    redirect(SITE_PATH . 'shop');
}
if (count(get_cart_data()) == 0) {
    redirect(SITE_PATH . 'shop');
}
if (isset($_SESSION['user_id'])) {
    $checkout_show = 'hide';
    $checkout_id = '';
    $billing_id = '#payment-2';
    $order_view_id = '#payment-3';
    $title = 'you are all ready login,no need';
    $show = 'show';
} else {
    $title = '';
    $checkout_id = '#payment-1';
    $checkout_show = 'show';
    $billing_id = '';
    $order_view_id = '';
    $show = '';
}
if (isset($_POST['billing_submit'])) {
    $name = get_safe_value($conn, $_POST['name']);
    $email = get_safe_value($conn, $_POST['email']);
    $address = get_safe_value($conn, $_POST['address']);
    $zip_code = get_safe_value($conn, $_POST['zip_code']);
    $country = get_safe_value($conn, $_POST['country']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $payment_type = get_safe_value($conn, $_POST['payment_type']);

    if (isset($_SESSION['coupon_code']) && isset($_SESSION['discount_price'])) {
        $coupon_name = $_SESSION['coupon_code'];
        $final_price = $_SESSION['discount_price'];
    } else {
        $coupon_name = '';
        $final_price = $total_amount;
    }


    $query = mysqli_query($conn, "insert into order_master(user_id,name,mobile,email,address,country,total_price,coupon_code,final_price,zip_code,dalivary_boy_id,payment_type,payment_status,order_status)
                                                                          values('" . $_SESSION['user_id'] . "','$name','$mobile','$email','$address','$country','$total_amount','$coupon_name','$final_price','$zip_code','1','$payment_type','panding','1') ");

    $order_id = mysqli_insert_id($conn);
    $get_cart_data = get_cart_data();
    foreach ($get_cart_data as $key => $val) {
        $price = $val['qty'] * $val['price'];
        $order_details_query = mysqli_query($conn, "insert into order_details (order_id,dis_details_id,price,qty) values('$order_id','$key','$price','" . $val['qty'] . "')");
    }
    if ($payment_type == 'cod') {
        $checkoutEmailHtml = checkoutEmailHtml($order_id);
        $subject = 'Your parchase invoice';
        $header = 'From: Fatimaakter444532@gmail.com' . "\r\n" .
                'Replay-To : Fatimaakter444532@gmail.com' . "\r\n" .
                'X-Mailer : php/' . phpversion() . "\r\n" .
                'Content-type: text/html; charset = iso-8859-1';
        mail($email, $subject, $checkoutEmailHtml, $header);
    }
    if ($payment_type == 'wallet') {
        insertWalletData($_SESSION['user_id'], $final_price, 'out', 'order-id:' . $order_id);
        $checkoutEmailHtml = checkoutEmailHtml($order_id);
        $subject = 'Your parchase invoice';
        $header = 'From: Fatimaakter444532@gmail.com' . "\r\n" .
                'Replay-To : Fatimaakter444532@gmail.com' . "\r\n" .
                'X-Mailer : php/' . phpversion() . "\r\n" .
                'Content-type: text/html; charset = iso-8859-1';
        mail($email, $subject, $checkoutEmailHtml, $header);
    }


    if ($query) {
        emptyCart();
        redirect(SITE_PATH . 'shop');
    } else {
        ?>
        <script type="text/javascript">
            swal("Error", 'Checkot is is invaild', "error");
        </script>
        <?php
    }
}
?>


<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Home</a></li>
                <li class="active"> Checkout </li>
            </ul>
        </div>
    </div>
</div>
<!-- checkout-area start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 title="<?= $title ?>" class="panel-title"><span>1.</span> <a data-toggle="collapse" data-parent="#faq" href="<?= $checkout_id ?>">Checkout method</a></h5>
                            </div>
                            <div id="payment-1" class="panel-collapse collapse <?= $checkout_show ?>">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="login-register-wrapper">
                                                <div class="login-register-tab-list nav">
                                                    <a class="active" data-toggle="tab" href="#lg1">
                                                        <h4> login </h4>
                                                    </a>
                                                    <a data-toggle="tab" href="#lg2">
                                                        <h4> register </h4>
                                                    </a>
                                                </div>
                                                <div class="tab-content">
                                                    <div id="lg1" class="tab-pane active">
                                                        <div class="login-form-container">
                                                            <div class="login-register-form">
                                                                <form id="login_form" method="post">
                                                                    <input type="email" name="email" placeholder="Email" required="">
                                                                    <input type="password" name="password" placeholder="Password" required="">
                                                                    <input  name="type" type="hidden" value="login">
                                                                    <input name="checkout_login" type="hidden" value="checkout_login">
                                                                    <div class="button-box">
                                                                        <div class="login-toggle-btn d-inline">
                                                                            <a href="forgot_password">Forgot Password?</a>
                                                                        </div>
                                                                        <button class="mt-2" id="login_submit_button" type="submit"><span>Login</span></button>
                                                                        <div id="login_error" class="feild_error_login"></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="lg2" class="tab-pane">
                                                        <div class="login-form-container">
                                                            <div class="login-register-form">
                                                                <form method="post" id="register_form">
                                                                    <input type="text" name="user-name" placeholder="Username">
                                                                    <input type="password" name="user-password" placeholder="Password">
                                                                    <input name="user-email" placeholder="Email" type="email">
                                                                    <div id="email_error" class="feild_error"></div>
                                                                    <input name="user-mobile" placeholder="Mobile" type="text">
                                                                    <input name="type" type="hidden" value="register">

                                                                    <div class="button-box" id="">
                                                                        <button id="submit_register" type="submit">Register</button>

                                                                    </div>
                                                                    <div class="text-success" id="success_field"></div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3.</span> <a data-toggle="collapse" data-parent="#faq" href="<?= $order_view_id ?>">Order Review</a></h5>
                            </div>
                            <div id="payment-3" class="panel-collapse collapse <?= $show ?>">
                                <div class="panel-body">
                                    <div class="order-review-wrapper">
                                        <div class="order-review">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="width-1">Food</th>
                                                            <th class="width-2">Price</th>
                                                            <th class="width-3">Qty</th>
                                                            <th class="width-4">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total_amount = 0;
                                                        foreach ($get_cart_data as $key => $val) {
                                                            $total_amount = ($total_amount + ($val['qty'] * $val['price']));
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <img class="img-fluid img_checkout" src="<?= SITE_DISH_IMAGE . $val['image'] ?>" alt=""></a>
                                                                        <p><?= $val['dish'] ?> </p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p><?= $val['price'] ?></p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p><?= $val['qty'] ?></p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p><?= $val['qty'] * $val['price'] ?></p>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3">Total </td>
                                                            <td colspan="1"><?= $total_amount ?> Tk</td>

                                                        </tr>
                                                        <tr id="coupon_applly">
                                                            <td colspan="3" class="discount">Final price</td>
                                                            <td class="discount_price"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <input type="text" placeholder="Coupon Code" name="coupon_applay" id="coupon_applay" class="coupon_input_width" />
                                                <div class="billing-btn d-inline">
                                                    <button type="button" onclick="coupon('<?= $total_amount ?>')">Apply</button>
                                                </div>
                                                <div class="coupon_msg_style" id="coupon_msg"></div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <span>
                                                    Forgot an Item?
                                                    <a href="<?= SITE_PATH ?>cart"> Edit Your Cart.</a>

                                                </span>
                                                <div class="billing-btn">
                                                    <button type="button" onclick="check_cat_min_value('<?= $total_amount ?>')">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2.</span> <a data-toggle="collapse" data-parent="#faq" href="<?= $billing_id ?>">billing information</a></h5>
                            </div>
                            <div id="payment-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label> Name</label>
                                                        <input type="text" name="name" required="" value="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Email Address</label>
                                                        <input type="email" name="email" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Address</label>
                                                        <input type="text" name="address" required="" value="">
                                                    </div>
                                                </div>


                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Zip/Postal Code</label>
                                                        <input type="text" name="zip_code" required="" value="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-select">
                                                        <label>Country</label>
                                                        <select name="country">
                                                            <option value="United State">United State</option>
                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                            <option value="Bahamas">Bahamas</option>
                                                            <option value="Bahrain">Bahrain</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Barbados">Barbados</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Mobile</label>
                                                        <input type="text" name="mobile" value="" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ship-wrapper">
                                                <div class="single-ship">
                                                    <input type="radio" name="payment_type" value="cod" checked="">
                                                    <label>Cash on delivary</label>
                                                </div>
                                                <div class="single-ship">
                                                    <input type="radio" name="payment_type" value="paytm">
                                                    <label>Paytm </label>
                                                </div>
                                                <?php
                                                $disabled = '';
                                                if (isset($_SESSION['discount_price'])) {
                                                    $discountPrice = $_SESSION['discount_price'];
                                                    $getWalletTotalAmount = getWalletTotalAmount($_SESSION['user_id']);
                                                    if ($discountPrice > $getWalletTotalAmount) {
                                                        $disabled = 'disabled="" ';
                                                    }
                                                } else {
                                                    $getWalletTotalAmount = getWalletTotalAmount($_SESSION['user_id']);
                                                    if ($total_amount > $getWalletTotalAmount) {
                                                        $disabled = 'disabled="" ';
                                                    }
                                                }
                                                ?>
                                                <div class="single-ship">
                                                    <input type="radio" <?= $disabled ?> name="payment_type" value="wallet">
                                                    <label>Wallet</label>
                                                </div>
                                            </div>


                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button type="submit" name="billing_submit" >Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="checkout-progress">
                    <h4>Checkout Progress</h4>
                    <ul>
                        <li>Billing Address</li>
                        <li>Shipping Address</li>
                        <li>Shipping Method</li>
                        <li>Payment Method</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_SESSION['coupon_code'])) {
    unset($_SESSION['coupon_code']);
    unset($_SESSION['discount_price']);
}
?>
<?php require_once './footer.php'; ?>