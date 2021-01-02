<?php
require_once './header.php';
$id = '';

if (isset($_POST['submit_money'])) {
    $uid = get_safe_value($conn, $_GET['id']);
    $money = get_safe_value($conn, $_POST['money']);
    $message = get_safe_value($conn, $_POST['message']);
   
    insertWalletData($uid,$money,'in',$message);
    redirect('users.php');
}
?>
<div class="row">
    <h1 class="card-title ml10">Add Money</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">Add Money</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Add Money" name="money"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Message</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Message" name="message"  required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_money"/>
                    <a href="users.php" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>