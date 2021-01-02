<?php
require_once './header.php';
$id = '';
if (isset($_GET['type']) && $_GET['type'] != '') {
    $update_type = get_safe_value($conn, $_GET['type']);
    if ($update_type == 'update') {
        $id = get_safe_value($conn, $_GET['id']);
        $check_query = mysqli_query($conn, "select * from coupon where id = $id ");
        if (mysqli_num_rows($check_query) > 0) {
            $assco = mysqli_fetch_assoc($check_query);
           // $coupon_type = $assco['type'];
        } else {
            redirect('coupon.php');
        }
    }
}
if (isset($_POST['submit_coupon'])) {
    $coupon_name = get_safe_value($conn, $_POST['coupon_name']);
    $type = get_safe_value($conn, $_POST['type']);
    $min_value = get_safe_value($conn, $_POST['min_value']);
    $value = get_safe_value($conn, $_POST['value']);
    $texpire_date = get_safe_value($conn, $_POST['expire_date']);

    if ($id == '') {
        $sql = " select * from coupon where status = 1 and coupon_name = '$coupon_name' ";
        $query = mysqli_query($conn, $sql);
    } else {
        $sql = " select * from coupon where status = 1 and coupon_name = '$coupon_name' and id !=$id ";
        $query = mysqli_query($conn, $sql);
    }
    if (mysqli_num_rows($query) > 0) {
        $msg = 'coupon name allready exits';
    } else {
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $update_type = get_safe_value($conn, $_GET['type']);
            if ($update_type == 'update') {
                $id = get_safe_value($conn, $_GET['id']);
                $query = mysqli_query($conn, "update coupon set coupon_name = '$coupon_name',coupon_type = '$type',coupon_value = '$value',cat_min_value = '$min_value',expire_date = '$texpire_date',status = 1 where id = $id ");
                if ($query) {
                    redirect('coupon.php');
                }
            }
        } else {
            $query = mysqli_query($conn, "insert into coupon (coupon_name,coupon_type,coupon_value,cat_min_value,expire_date,status) values('$coupon_name','$type','$value','$min_value','$texpire_date','1') ");
            if ($query) {
                redirect('coupon.php');
            }
        }
    }
}
?>
<div class="row">
    <h1 class="card-title ml10">Basic form elements</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder=" Name" name="coupon_name" value="<?= (isset($assco['coupon_name'])) ? $assco['coupon_name'] : '' ?>" required="">
                        <span class="feild_error"><?= (isset($msg)) ? $msg : '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Type</label>
                        <select name="type" id="" class="form-control" required="">
                            <option value="">-----</option> 
                        
                            <option value="parcent">parcent</option> 
                            <option value="fixed">fixed</option> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Min Value </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Min value" name="min_value" value="<?= (isset($assco['cat_min_value'])) ? $assco['cat_min_value'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Value </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="value " name="value" value="<?= (isset($assco['coupon_value'])) ? $assco['coupon_value'] : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Expire Date</label>
                        <input type="date" class="form-control" id="exampleInputEmail3" placeholder="Expire Date" name="expire_date" value="<?= (isset($assco['expire_date'])) ? $assco['expire_date'] : '' ?>" required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_coupon"/>
                    <a href="category.php" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>