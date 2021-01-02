<?php
require_once '../config/database.php';
require_once '../config/function.php';
require_once '../config/coreConfig.php';
require_once '../config/constant.php';
if (!isset($_SESSION['ADMIN_LOGIN'])) {
    redirect('login.php');
}
$full_link = $_SERVER['PHP_SELF'];
$explode_link = explode('/', $full_link);

$link = end($explode_link);


//$page = 'Food Ordaring';
if ($link == 'index.php') {
    $page = 'Dashboard';
} else if ($link == 'category.php' || $link == 'add_category.php') {
    $page = 'Category';
} else if ($link == 'coupon.php' || $link == 'add_coupon.php') {
    $page = 'Coupon';
} else if ($link == 'dalivary_boy.php' || $link == 'add_dalivary.php') {
    $page = 'Dalivary Boy';
} else if ($link == 'users.php') {
    $page = 'Users';
} else if ($link == 'dish.php' || $link == 'add_dish.php' || $link == 'update_dish.php') {
    $page = 'Dish';
} else if ($link == 'banner.php' || $link == 'add_banner.php' || $link == 'update_banner.php') {
    $page = 'Banner';
} else if ($link == 'contact.php') {
    $page = 'Contact';
} else if ($link == 'order.php') {
    $page = 'Order';
} else if ($link == 'order_details.php') {
    $page = 'ordere details';
} else if ($link == 'setting.php') {
    $page = 'setting';
}
//echo $page;   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= $page ?></title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="../assets/backend//css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../assets/backend/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../assets/backend/css/dataTables.bootstrap4.css">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="../assets/backend/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="../assets/backend/css/font-awesome.min.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="../assets/backend/css/style.css">
        <link rel="stylesheet" href="../assets/backend/css/costom.css">
    </head>
    <body class="sidebar-light">
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                    <ul class="navbar-nav mr-lg-2 d-none d-lg-flex">
                        <li class="nav-item nav-toggler-item">
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                                <span class="mdi mdi-menu"></span>
                            </button>
                        </li>

                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="index.html"><img src="../assets/backend/images/logo.png" alt="logo"/></a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../assets/backend/images/logo.png" alt="logo"/></a>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">

                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                <span class="nav-profile-name"><?= ucwords($_SESSION['ADMIN_NAME']) ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                        <li class="nav-item nav-toggler-item-right d-lg-none">
                            <button class="navbar-toggler align-self-center" type="button" data-toggle="offcanvas">
                                <span class="mdi mdi-menu"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_settings-panel.html -->
                <!-- partial -->
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="mdi mdi-view-quilt menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Category</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="coupon.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Coupon</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dalivary_boy.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Delivary boy</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Users </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dish.php">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Dish </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="order">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Order </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="banner">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Banner </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Contact </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="setting">
                                <i class="mdi mdi-view-headline menu-icon"></i>
                                <span class="menu-title">Setting </span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">