<?php
require_once './header.php';
$id = '';
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
    if ($type == 'update') {
        $id = get_safe_value($conn, $_GET['id']);
        $check_query = mysqli_query($conn, "select * from delivery_boy where id = $id ");
        if (mysqli_num_rows($check_query) > 0) {
            $assco = mysqli_fetch_assoc($check_query);
        } else {
            redirect('dalivary_boy.php');
        }
    }
}
if (isset($_POST['submit_dalivary'])) {
    $dalivary_name = get_safe_value($conn, $_POST['dalivary_name']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $password = get_safe_value($conn, $_POST['password']);

    if ($id == '') {
        $sql = " select * from delivery_boy where status = 1 and mobile = '$mobile' ";
        $query = mysqli_query($conn, $sql);
    } else {
        $sql = " select * from delivery_boy where status = 1 and mobile = '$mobile' and id != $id ";
        $query = mysqli_query($conn, $sql);
    }
    if (mysqli_num_rows($query) > 0) {
       $assco = mysqli_fetch_assoc($query);
        $msg = 'mobile number allready exits';
    } else {
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $type = get_safe_value($conn, $_GET['type']);
            if ($type == 'update') {
                $id = get_safe_value($conn, $_GET['id']);
                $query = mysqli_query($conn, "update delivery_boy set name = '$dalivary_name',mobile = '$mobile',password = '$password' where id = $id ");
                if ($query) {
                    redirect('dalivary_boy.php');
                }
            }
        } else {
            $query = mysqli_query($conn, "insert into delivery_boy (name,mobile,password,status) values('$dalivary_name','$mobile','$password','1') ");
            if ($query) {
                redirect('dalivary_boy.php');
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
                        <label for="exampleInputName1"> Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder=" Name" name="dalivary_name" value="<?= (isset($assco['name'])) ? $assco['name'] : '' ?>" required="">
                      
                    </div>
                     <div class="form-group">
                        <label for="exampleInputName1"> Mobile</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Mobile " name="mobile" value="<?= (isset($assco['mobile'])) ? $assco['mobile'] : '' ?>" required="">
                        <span class="feild_error"><?= (isset($msg)) ? $msg : '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Password</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="password" name="password" value="<?= (isset($assco['password'])) ? $assco['password'] : '' ?>" required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_dalivary"/>
                    <a href="dalivary_boy.php" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>