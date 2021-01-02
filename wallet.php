<?php
require_once './header.php';
if (!isset($_SESSION['user_id'])) {
    redirect(SITE_PATH . 'shop');
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
                                <div class="row">
                                    <div class="col-12">
                                        <div class="contact-message-wrapper">
                                            <h4 class="contact-title">Add Money Wallet</h4>
                                            <div class="contact-message">
                                                <form id="contact-form" action="submit_contact.php" method="post">
                                                    <div class="row">
                                                        <div class="col-lg-2 pr-0">
                                                            <div class="contact-form-style mb-20">
                                                                <input name="wallet_amt" placeholder="Amount" type="text" required="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 pr-0">
                                                            <div class="wallet contact-form-style mb-20">
                                                                <a href="#" class="">Apply</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="">S.No.</th>
                                                <th class="width-2">Amount</th>
                                                <th class="width-3">Type</th>
                                                <th class="width-4">Message</th>
                                                <th>Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $getWallet = getWallet($_SESSION['user_id']);
                                            foreach ($getWallet as $val) {
                                                //pr($val);
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <div class="o-pro-price <?= $val['type'] ?>">
                                                            <?= $val['wallet_amt'] ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-qty <?= $val['type'] ?>">
                                                            <?= $val['type'] ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-subtotal">
                                                            <?= $val['message'] ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="o-pro-subtotal">
                                                            <?= $val['insertdate'] ?>
                                                        </div>
                                                    </td>


                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </tbody>


                                    </table>
                                </div>
                                <div class="cart-clear">
                                    <a href="shop" class="">back</a>
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