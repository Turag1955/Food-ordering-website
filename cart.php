<?php
require_once './header.php';
// pr($_POST);
if ($website_close == 1) {
    redirect(SITE_PATH . 'shop');
}
?>
<div class="cart-main-area pt-95 pb-100">
    <div class="container">
        <h3 class="page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <?php
                if (count(get_cart_data()) > 0) {
                    ?>
                    <form method="post">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Until Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($get_cart_data as $key => $list) {
                                        ?>
                                        <tr id="attr_<?= $key ?>">
                                            <td class="product-thumbnail">
                                                <a href="javascript:void(0)"><img class="img-fluid" src="<?= SITE_DISH_IMAGE . $list['image'] ?>" alt=""></a>
                                            </td>
                                            <td class="product-name"><a href="javascript:void(0)"><?= $list['dish'] ?></a></td>
                                            <td class="product-price-cart"><span class="amount"><?= $list['price'] ?> </span></td>
                                            <td class="product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" type="text" name="qty[<?= $key ?>][]" value="<?= $list['qty'] ?>">
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><?= $list['qty'] * $list['price'] ?>Tk</td>
                                            <td class="product-remove">
                                                <a  href="javascript:void(0)" onclick="delete_cart('<?= $key ?>', 'cart_delete')"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="<?= SITE_PATH ?>shop">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear">
                                        <button type="submit" name="update_qty" >Update Shopping Cart</button>
                                        <a href="<?= SITE_PATH ?>checkout">checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    redirect('shop');
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>