<?php
require_once './header.php';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $order_id = get_safe_value($conn, $_GET['id']);
} else {
    redirect(SITE_PATH_ADMIN . 'order');
}
?>

<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="panel-body">
                        <div class="order-review-wrapper">
                            <div class="order-review">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="">Food</th>
                                                <th class="width-2">Price</th>
                                                <th class="width-3">Qty</th>
                                                <th class="width-4">Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT order_details.*,dish.dish,dish.image,order_master.coupon_code,order_master.final_price,order_master.order_status,dish_details.price
                                                                                            FROM order_details,dish,dish_details,order_master
                                                                                            WHERE order_master.id = order_details.order_id and  order_details.order_id = '$order_id' and
                                                                                            order_details.dis_details_id = dish_details.id AND 
                                                                                            dish_details.dis_id = dish.id  ");
                                            $total_amount = 0;
                                            $coupon_code = '';
                                            $coupon_final_price = 0;
                                            $order_status = 0;
                                            while ($val = mysqli_fetch_assoc($query)) {
                                              //pr($val);
                                                $total_amount = ($total_amount + ($val['qty'] * $val['price']));
                                                $coupon_code = $val['coupon_code'];
                                                $coupon_final_price = $val['final_price'];
                                                $order_status = $val['order_status'];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div class="o-pro-dec">
                                                            <img class="img-fluid img_checkout" src="<?= SITE_DISH_IMAGE . $val['image'] ?>" alt=""></a>
                                                            <p class="d-inline"><?= $val['dish'] ?> </p>
                                                            <?php
                                                            if ($order_status == 5) {
                                                                getRating($val['dis_details_id'],$order_id);
                                                            }
                                                            ?>

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
                                                <td colspan="3">Total : </td>
                                                <td class="text-center" colspan="1"><?= $total_amount ?> Tk</td>
                                            </tr>
                                            <?php
                                            if ($coupon_code != '') {
                                                ?>
                                                <tr>
                                                    <td  colspan="3">Coupon name : </td>
                                                    <td class="text-center"><?= $coupon_code ?></td>
                                                </tr>
                                                <tr>
                                                    <td  colspan="3">Final price : </td>
                                                    <td class="text-center" colspan="1"><?= $coupon_final_price ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                                
                                        </tfoot>
                                
                                    </table>
                                </div>
                                <div class="cart-clear">
                                    <a href="order" class="">back</a>
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