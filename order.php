<?php
require_once './header.php';
//prx(get_cart_data());

if (!isset($_SESSION['user_id'])) {
    redirect(SITE_PATH . 'shop');
}
if (isset($_GET['order_id']) && $_GET['order_id'] != '') {
    $order_id = get_safe_value($conn, $_GET['order_id']);
    $cancel_date = date('Y-m-d h:i:s');
    $query = mysqli_query($conn,"UPDATE order_master SET order_status = '2',cancel_by= 'users',cancel_date='$cancel_date'  WHERE user_id = '".$_SESSION['user_id']."' AND order_status = 1 AND id = $order_id");
}
$query = mysqli_query($conn, "SELECT order_master.*,order_status.order_status as orderstatus
                                               FROM order_master,order_status 
                                              WHERE order_master.order_status = order_status.id and order_master.user_id = ' " . $_SESSION['user_id'] . " '
                                                ORDER by order_master.id DESC");
?>
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Your Order History</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                <form method="post">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th width="5%">order id</th>

                                    <th>Address</th>
                                    <th>payment Type</th>
                                    <th>payment status</th>
                                    <th>order status</th>
                                    <th>order details</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($assoc = mysqli_fetch_assoc($query)) {
                                    ?> 
                                    <tr>
                                        <td>
                                            #<?= $assoc['id'] ?>
                                            <a href=""><p class="pdf_invoice" title="Downlod pdf"><i class="fa fa-print"></i></p></a>
                                        </td>
                                        <td>
                                            <?= ucfirst($assoc['address']) ?>
                                        </td>
                                        <td> <?= ucfirst($assoc['payment_type']) ?></td>

                                        <td><div class="td_style_warning"><?= $assoc['payment_status'] ?></div></td>
                                        <td>
                                            <div class="td_style_info"><?= $assoc['orderstatus'] ?></div>
                                            <?php
                                            if ($assoc['order_status'] == 1) {

                                                echo '<div class="mt-2"><a class="cencel_btn" href="?order_id=' . $assoc['id'] . ' ">cencel</a></div>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <a href="order_details?id=<?= $assoc['id'] ?>" class="btn btn-primary">Order Details</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>