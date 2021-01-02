<?php
require_once '../config/database.php';
require_once '../config/function.php';
require_once '../config/coreConfig.php';
$msg = [];
if (isset($_POST['login'])) {
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $password = get_safe_value($conn, $_POST['password']);


    $query = mysqli_query($conn, "select * from delivery_boy where mobile = '$mobile' and password = '$password'");
    if (mysqli_num_rows($query) > 0) {
        $assoc = mysqli_fetch_assoc($query);
        if ($assoc['status'] == 1) {
            $_SESSION['DELIVERY_BOY_LOGIN'] = 'yes';
            $_SESSION['DELIVERY_BOY_ID'] = $assoc['id'];
            $_SESSION['DELIVERY_BOY_NAME'] = $assoc['name'];
            redirect('order_delivery.php');
        } else {
            $msg [] = 'your id is deactive';
        }
    } else {
        $msg [] = 'your mobile or password wrong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Delivery Boy || Food Ordering </title>
        <link rel="stylesheet" href="../assets/backend/css/style.css">
    </head>
    <body class="sidebar-light">
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row w-100">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="brand-logo text-center">
                                    <img src="../assets/backend/images/logo.png" alt="logo">
                                </div>
                                <?php
                                if (isset($msg)) {
                                    foreach ($msg as $error) {
                                        ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                        <?php
                                    }
                                }
                                ?>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" action="" method="post">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Mobile" name="mobile" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password" required="">
                                    </div>
                                    <div class="mt-3">
                                        <input type="submit" value="SIGN IN" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" />
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </body>
</html>