<?php
require_once './header.php';

$check_query = mysqli_fetch_assoc(mysqli_query($conn, "select * from setting where id = 1 "));


if (isset($_POST['submit_setting'])) {
    $website_close = get_safe_value($conn, $_POST['website_close']);
    $website_close_msg = get_safe_value($conn, $_POST['website_close_msg']);
    $cart_min_amount = get_safe_value($conn, $_POST['cart_min_amount']);
    $cart_min_amount_msg = get_safe_value($conn, $_POST['cart_min_amount_msg']);
    $wallet_amt = get_safe_value($conn, $_POST['wallet_amt']);
    $referral_amt = get_safe_value($conn, $_POST['referral_amt']);


    $query = mysqli_query($conn, "update setting set website_close = '$website_close',website_close_msg = '$website_close_msg',cart_min_amount = '$cart_min_amount',cart_min_amount_msg = '$cart_min_amount_msg',wallet_amt = '$wallet_amt',referral_amt = '$referral_amt' where id = 1 ");
    if ($query) {
        redirect('setting');
    }
}
$website_close_array = ['No', 'Yes'];
?>
<div class="row">
    <h1 class="card-title ml10">Setting</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">website close</label>
                        <select name="website_close" class="form-control">
                            <option value="">Select Option</option>
                            <?php
                            foreach ($website_close_array as $key => $val) {
                                if ($key == $check_query['website_close']) {
                                    echo '<option selected value=' . $key . '>' . $val . '</option>';
                                } else {
                                    echo '<option  value=' . $key . '>' . $val . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName1">Website close Msg </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Website close Msg" name="website_close_msg" value="<?= (isset($check_query['website_close_msg'])) ? $check_query['website_close_msg'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">cart min amount </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="cart min amount " name="cart_min_amount" value="<?= (isset($check_query['cart_min_amount'])) ? $check_query['cart_min_amount'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">cart min amount msg</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="cart min amount msg" name="cart_min_amount_msg" value="<?= (isset($check_query['cart_min_amount_msg'])) ? $check_query['cart_min_amount_msg'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Wallet Amount</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Wallet Amount" name="wallet_amt" value="<?= (isset($check_query['wallet_amt'])) ? $check_query['wallet_amt'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Referral Amount</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Referral Amount" name="referral_amt" value="<?= (isset($check_query['referral_amt'])) ? $check_query['referral_amt'] : '' ?>" required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_setting"/>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>