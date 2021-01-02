<?php
require_once '../config/database.php';
require_once '../config/function.php';
require_once '../config/coreConfig.php';
$msg = [];
if (isset($_POST['login'])) {
    $usersname = get_safe_value($conn, $_POST['usersname']);
    $password = get_safe_value($conn, $_POST['password']);


    $query = mysqli_query($conn, "select * from admin where usersname = '$usersname' and password = '$password'");
    if (mysqli_num_rows($query) > 0) {
        $assoc = mysqli_fetch_assoc($query);
        if ($assoc['status'] == 1) {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_ID'] = $assoc['id'];
            $_SESSION['ADMIN_NAME'] = $assoc['usersname'];
            redirect('index.php');
        } else {
            $msg [] = 'your id is deactive';
        }
    } else {
        $msg [] = 'your usersname or password wrong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Food Ordering Admin</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="../assets/backend//css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../assets/backend/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="../assets/backend/css/bootstrap-datepicker.min.css">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
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
                                        <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" name="usersname" required="">
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

        <!-- plugins:js -->
        <script src="../assets/backend/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="../assets/backend/js/Chart.min.js"></script>
        <script src="../assets/backend/js/bootstrap-datepicker.min.js"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="../assets/backend/js/off-canvas.js"></script>
        <script src="../assets/backend/js/hoverable-collapse.js"></script>
        <script src="../assets/backend/js/template.js"></script>
        <script src="../assets/backend/js/settings.js"></script>
        <script src="../assets/backend/js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="../assets/backend/js/dashboard.js"></script>
        <!-- End custom js for this page-->
    </body>
</html>