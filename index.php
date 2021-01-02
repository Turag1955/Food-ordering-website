<?php
require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Billy - Food & Drink eCommerce Bootstrap4 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/frontend/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/frontend/css/animate.css">
        <link rel="stylesheet" href="assets/frontend/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/frontend/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/frontend/css/style.css">
        <link rel="stylesheet" href="assets/frontend/css/costom.css">
        <link rel="stylesheet" href="assets/frontend/css/responsive.css">
        <script src="assets/frontend/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-12">
                <div class="slider-area">
                    <div class="slider-active owl-dot-style owl-carousel">
                        <?php
                        $banner_query = mysqli_query($conn, "select * from banner where status = 1 ");
                        while ($banner_assoc = mysqli_fetch_assoc($banner_query)) {
                            ?>
                            <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url(<?= SITE_BANNER_IMAGE . $banner_assoc['image'] ?>);">
                                <div class="container">
                                    <div class="slider-content slider-animated-1">
                                        <h1 class="animated ml-5 ml-sm-5"><?= $banner_assoc['heading'] ?></h1>
                                        <h3 class="animated"><?= $banner_assoc['sub_heading'] ?>.</h3>
                                        <div class="slider-btn mt-90">
                                            <a class="animated" href="<?= $banner_assoc['link'] ?>"><?= $banner_assoc['link_text'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>


                    </div>
                </div>
            </div>
        </div>

        <script src="assets/frontend/js/vendor/jquery-1.12.0.min.js"></script>
        <script src="assets/frontend/js/bootstrap.min.js"></script>
        <script src="assets/frontend/js/imagesloaded.pkgd.min.js"></script>
        <script src="assets/frontend/js/isotope.pkgd.min.js"></script>
        <script src="assets/frontend/js/owl.carousel.min.js"></script>
        <script src="assets/frontend/js/plugins.js"></script>
        <script src="assets/frontend/js/main.js"></script>
    </body>
</html>
