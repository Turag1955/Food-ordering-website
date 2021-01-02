<?php
require_once '../config/database.php';
require_once '../config/function.php';
require_once '../config/coreConfig.php';
require_once '../config/constant.php';
if (!isset($_SESSION['DELIVERY_BOY_ID'])) {
    redirect('login.php');
}
if (isset($_GET['id']) && $_GET['id'] != '') {
    $order_id = get_safe_value($conn, $_GET['id']);
    $date = date('d-m-y h:i');
    
    //echo "update order_master set order_status = 5, delivery_date = '$date' where id = $order_id and dalivary_boy_id = ' " . $_SESSION['DELIVERY_BOY_ID'] . " ' ";
    $query = mysqli_query($conn, "update order_master set order_status = 5, delivery_date = '$date' where id = $order_id and dalivary_boy_id = ' " . $_SESSION['DELIVERY_BOY_ID'] . " ' ");
    if ($query) {
       // redirect('order_delivery.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Delivery Boy</title>

        <link rel="stylesheet" href="../assets/backend/css/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="../assets/backend/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/backend/css/style.css">
        <link rel="stylesheet" href="../assets/backend/css/costom.css">

    </head>
    <body class="sidebar-light">
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">

                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center m-auto">
                        <a class="navbar-brand brand-logo" href="order_delivery.php">Food ordering</a>

                        <a class="navbar-brand brand-logo-mini" href="order_delivery.php">Food ordering</a>

                    </div>
                    <div class="align-items-center text-center justify-content-center  d-flex mr-3">
                        <a class=" text-dark" href="logout.php">logout</a>
                    </div>

                </div>

            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper" style="width:79%; margin-top: 150px">
                <!-- partial -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th width="10">Serial No.</th>
                                                <th>Customer Info </th>
                                                <th>Address</th>  
                                                <th>Amount</th>
                                                <th>Payment type</th>  
                                                <th>Payment status</th>  
                                                <th>Order status</th>  

                                                <th>Added On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT order_master.*,order_status.order_status as orderstatus
                                                                            FROM order_master,order_status 
                                                                            WHERE order_master.order_status = order_status.id  and order_master.order_status !=5
                                                                            ORDER by order_master.id DESC");
                                            $i = 1;
                                            while ($assoc = mysqli_fetch_assoc($query)) {
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <p>Name- <?= ucfirst($assoc['name']) ?></p>
                                                        <p>Mobile- <?= $assoc['mobile'] ?></p>
                                                    </td>
                                                    <td>
                                                        <p><?= ucfirst($assoc['address']) ?></p>
                                                        <p><?= ucfirst($assoc['country']) ?></p>
                                                        <p><?= $assoc['zip_code'] ?></p>
                                                    </td>
                                                    <td><?= $assoc['final_price'] ?></td>
                                                    <td><?= $assoc['payment_type'] ?></td>
                                                    <td class="text-warning"><?= $assoc['payment_status'] ?></td>
                                                    <td class="text-info"><a class="btn btn-primary" href="?id=<?= $assoc['id'] ?>">Delivered</a></td>
                                                    <td><?php echo dateFormate($assoc['insertdate']) ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <script src="../assets/backend/js/jquery.dataTables.js"></script>
        <script src="../assets/backend/js/dataTables.bootstrap4.js"></script>
        <script src="../assets/backend/js/data-table.js"></script>
    </body>
</html>