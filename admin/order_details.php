<?php
require_once './header.php';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $order_id = get_safe_value($conn, $_GET['id']);

    if (isset($_GET['order_status']) && $_GET['order_status'] != '') {
        $order_status_id = get_safe_value($conn, $_GET['order_status']);

        if ($order_status_id == 5) {
            $getSetting = getSetting();
            $referral_amt = $getSetting['referral_amt'];
            if ($referral_amt > 0) {
                $result = mysqli_fetch_assoc(mysqli_query($conn, "select user_id from order_master where id = '$order_id' "));
                $user_id = $result['user_id'];
                $res = mysqli_query($conn, "select from_referral_code from users where id = '$user_id' ");
                if (mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $from_referral_code = $row['from_referral_code'];
                    $result = mysqli_fetch_assoc(mysqli_query($conn, "select id from users where referral_code = '$from_referral_code' "));
                    $uid = $result['id'];
                    insertWalletData($uid, $referral_amt, 'in', 'Referral Bounus');
                }
            }
        }


        if ($order_status_id == 2) {
            $cancel_date = date('Y-m-d h:i:s');
            $update_order_status = mysqli_query($conn, "update order_master set order_status = '$order_status_id',cancel_by= 'admin',cancel_date='$cancel_date' where id = '$order_id' ");
        } else {
            $update_order_status = mysqli_query($conn, "update order_master set order_status = '$order_status_id' where id = '$order_id' ");
        }

        if ($update_order_status) {
            redirect(SITE_PATH_ADMIN . 'order_details?id=' . $order_id);
        }
    }

    if (isset($_GET['delivery_boy']) && $_GET['delivery_boy'] != '') {
        $delivery_boy_id = get_safe_value($conn, $_GET['delivery_boy']);

        $update_delivery_boy = mysqli_query($conn, "update order_master set dalivary_boy_id	 = '$delivery_boy_id' where id = '$order_id' ");
        if ($update_delivery_boy) {
            redirect(SITE_PATH_ADMIN . 'order_details?id=' . $order_id);
        }
    }
    $query = mysqli_query($conn, "SELECT order_master.*,order_status.order_status as orderstatus,delivery_boy.name as delivary_name,delivery_boy.mobile
                                                                            FROM order_master,order_status,delivery_boy
                                                                            WHERE order_master.dalivary_boy_id = delivery_boy.id and  order_master.order_status = order_status.id  and order_master.id = '$order_id'
                                                                            ORDER by order_master.id DESC");
    $order_master_assoc = mysqli_fetch_assoc($query);
} else {
    redirect(SITE_PATH_ADMIN . 'order');
}
?>

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row my-5 py-5">
                <div class="col-12 text-right mb-5 pb-5">
                    <h3>Invoice #<?= $order_id ?></h3>
                </div>
                <div class="col-6">
                    <h4>Admin</h4>
                    <p>Sadar Hospital Road,</p>
                    <p>Feni-3900</p>
                </div>
                <div class="col-6 text-right">
                    <h4>Invoice to <?= ucfirst($order_master_assoc['name']) ?></h4>
                    <p>
                        <?= ucfirst($order_master_assoc['address']) ?> <br />
                        <?= ucfirst($order_master_assoc['country']) ?> <br />
                        <?= ucfirst($order_master_assoc['zip_code']) ?> 
                    </p>

                </div>
                <div class="col-12 mt-5">

                    <p>Invoice Date:<?= dateFormate($order_master_assoc['insertdate']) ?> </p>
                    <p>Due Date: </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

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
                                            $query = mysqli_query($conn, "SELECT order_details.*,dish.dish,dish.image,order_master.address,order_master.country,order_master.zip_code
                                                                                            FROM order_details,dish,dish_details,order_master
                                                                                            WHERE order_master.id = order_details.order_id and  order_details.order_id = '$order_id' and
                                                                                            order_details.dis_details_id = dish_details.id AND 
                                                                                            dish_details.dis_id = dish.id  ");
                                            $total_amount = 0;
                                            while ($val = mysqli_fetch_assoc($query)) {
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
                                                <td colspan="2"><?= $total_amount ?> Tk</td>
                                            </tr>
                                            <?php
                                            if ($order_master_assoc['coupon_code'] != '') {
                                                ?>
                                                <tr>
                                                    <td colspan="3">Final price</td>
                                                    <td colspan="1"><?= $order_master_assoc['coupon_code'] . '-' . $order_master_assoc['final_price'] ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tfoot>
                                    </table>
                                </div>
                                <br /><br />
                                <div class="billing-back-btn">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="">Order Status -  <?= ucfirst($order_master_assoc['orderstatus']) ?></label>
                                            <select class="form-control" name="order_status" id="order_status" onchange="order_status_update(<?= $order_id ?>)" style="width: 40%">
                                                <option value="">Select order status</option>
                                                <?php
                                                $order_status = mysqli_query($conn, "select * from order_status order by order_status");
                                                while ($order_status_assoc = mysqli_fetch_assoc($order_status)) {
                                                    echo '  <option value=" ' . $order_status_assoc['id'] . ' "> ' . $order_status_assoc['order_status'] . ' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="">Dalivery Boy : <?= ucfirst($order_master_assoc['delivary_name']) . ', Mobile-' . $order_master_assoc['mobile'] ?></label>
                                            <select class="form-control" name="delivery_boy" id="delivery_boy" onchange="delivery_boy_select(<?= $order_id ?>)" style="width: 40%">
                                                <option value="">Dalivery Boy </option>
                                                <?php
                                                $delivery = mysqli_query($conn, "select * from delivery_boy order by id");
                                                while ($delivery_assoc = mysqli_fetch_assoc($delivery)) {
                                                    echo '  <option value=" ' . $delivery_assoc['id'] . ' "> ' . $delivery_assoc['name'] . ' </option>';
                                                }
                                                ?>
                                            </select>
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
</div>
<?php require_once './footer.php'; ?>