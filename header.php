<?php
require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
//prx(get_order_details(2));
//prx($_SESSION);
$getSetting = getSetting();
$website_close = $getSetting['website_close'];
$website_close_msg = $getSetting['website_close_msg'];
$cart_min_amount = $getSetting['cart_min_amount'];
$cart_min_amount_msg = $getSetting['cart_min_amount_msg'];
getAllDishStatus();
if (isset($_POST['update_qty'])) {
    foreach ($_POST['qty'] as $key => $val) {
        if (isset($_SESSION['user_id'])) {
            if ($val[0] == 0) {
                $res = mysqli_query($conn, "delete from dish_cart where user_id = ' " . $_SESSION['user_id'] . " ' and dish_details_id = $key ");
            } else {
                $res = mysqli_query($conn, "update dish_cart set qty = '$val[0]' where user_id = ' " . $_SESSION['user_id'] . " ' and dish_details_id = $key ");
            }
        } else {
            if ($val[0] == 0) {
                unset($_SESSION['cart'][$key]['qty']);
            } else {
                $_SESSION['cart'][$key]['qty'] = $val[0];
            }
        }
    }
}


$total_amount = 0;
$get_cart_data = get_cart_data();
foreach ($get_cart_data as $val) {
    $total_amount = ($total_amount + ($val['qty'] * $val['price']));
}
$total_cart = count($get_cart_data);
if (isset($_SESSION['user_id'])) {
    $getWalletTotalAmount = getWalletTotalAmount($_SESSION['user_id']);
}
?>


<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Billy - Food & Drink eCommerce Bootstrap4 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/animate.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/slick.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/chosen.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/ionicons.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/simple-line-icons.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/jquery-ui.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/meanmenu.min.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/style.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/responsive.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/sweetalert.css">
        <link rel="stylesheet" href="<?= SITE_PATH ?>./assets/frontend/css/costom.css">
        <script src="<?= SITE_PATH ?>./assets/frontend/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!-- header start -->
        <header class="header-area">
            <div class="header-top black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                            <div class="welcome-area">

                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION['user_name'])){
                            ?>
                            <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                                <div class="text-center wallet_style">
                                    <a href="wallet">Wallet Amount  <?=$getWalletTotalAmount?> Tk </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-8 col-12 col-sm-8">
                                <div class="account-curr-lang-wrap f-right">  
                                    <ul>
                                        <li class="top-hover"><a href="javascript:void(0)" id="profile_name">Welcome <?= ucfirst($_SESSION['user_name']) ?> <i class="ion-chevron-down"></i></a>
                                            <ul>
                                                <li><a href="<?= SITE_PATH ?>order">Order</a></li>
                                                <li><a href="<?= SITE_PATH ?>Profile">Profile </a></li>
                                                <li><a href="<?= SITE_PATH ?>logout">Logout </a></li>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                            <div class="logo">
                                <a href="<?= SITE_PATH ?>index">
                                    <img alt="" src="<?= SITE_PATH ?>./assets/frontend/img/logo/logo.png">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                            <div class="header-middle-right f-right">
                                <?php
                                if (!isset($_SESSION['user_id'])) {
                                    ?>
                                    <div class="header-login">
                                        <a href="<?= SITE_PATH ?>login_register">
                                            <div class="header-icon-style">
                                                <i class="icon-user icons"></i>
                                            </div>
                                            <div class="login-text-content">
                                                <p>Register <br> or <span>Sign in</span></p>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="header-wishlist">
                                    &nbsp;
                                </div>
                                <div class="header-cart">
                                    <a href="">
                                        <div class="header-icon-style">
                                            <i class="icon-handbag icons"></i>
                                            <span class="count-style"><?= $total_cart ?></span>
                                        </div>
                                        <div class="cart-text">
                                            <span class="digit">My Cart</span>
                                            <span class="cart-digit-bold"><?= $total_amount ?></span>
                                        </div>
                                    </a>
                                    <?php
                                    if ($total_cart != 0) {
                                        ?>
                                        <div class="shopping-cart-content">
                                            <ul id="li_add">
                                                <?php
                                                foreach ($get_cart_data as $key => $list) {
                                                    ?>
                                                    <li class="single-shopping-cart" id="attr_<?= $key ?>">
                                                        <div class="shopping-cart-img">
                                                            <a href="#"><img class="img-fluid" alt="" src="<?= SITE_DISH_IMAGE . $list['image'] ?>"></a>
                                                        </div>
                                                        <div class="shopping-cart-title">
                                                            <h4><a href="#"><?= $list['dish'] ?></a></h4>
                                                            <h6>Qty:<?= $list['qty'] ?></h6>
                                                            <span><?= $list['qty'] * $list['price'] ?>Tk</span>
                                                        </div>
                                                        <div class="shopping-cart-delete">
                                                            <a href="javascript:void(0)" onclick="delete_cart('<?= $key ?>', 'cart_delete')"><i class="ion ion-close"></i></a>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <div class="shopping-cart-total">
                                                <h4>Total : <span class="shop-total"><?= $total_amount ?>Tk</span></h4>
                                            </div>
                                            <div class="shopping-cart-btn">
                                                <a href="<?= SITE_PATH ?>cart">View Cart</a>
                                                <a href="<?= SITE_PATH ?>checkout">checkout</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom transparent-bar black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li><a href="<?= SITE_PATH ?>shop">Home</a></li>
                                        <li><a href="<?= SITE_PATH ?>about">about</a></li>
                                        <li><a href="<?= SITE_PATH ?>contact">contact us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area-start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mobile-menu">
                                <nav id="mobile-menu-active">
                                    <ul class="menu-overflow" id="nav">
                                        <li><a href="<?= SITE_PATH ?>index">Home</a></li>
                                        <li><a href="<?= SITE_PATH ?>about-us">About</a></li>
                                        <li><a href="<?= SITE_PATH ?>contact">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area-end -->
        </header>