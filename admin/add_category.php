<?php
require_once './header.php';
$id = '';
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
    if ($type == 'update') {
        $id = get_safe_value($conn, $_GET['id']);
        $check_query = mysqli_query($conn, "select * from category where id = $id ");
        if (mysqli_num_rows($check_query) > 0) {
            $assco = mysqli_fetch_assoc($check_query);
        } else {
            redirect('category.php');
        }
    }
}
if (isset($_POST['submit_category'])) {
    $category = get_safe_value($conn, $_POST['category']);
    $order_number = get_safe_value($conn, $_POST['order_number']);

    if ($id == '') {
        $sql = " select * from category where status = 1 and category = '$category'";
        $query = mysqli_query($conn, $sql);
    } else {
        $sql = " select * from category where status = 1 and category = '$category' and id != $id ";
        $query = mysqli_query($conn, $sql);
    }
    if (mysqli_num_rows($query) > 0) {
        $msg = 'category name allready exits';
    } else {
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $type = get_safe_value($conn, $_GET['type']);
            if ($type == 'update') {
                $id = get_safe_value($conn, $_GET['id']);
                $query = mysqli_query($conn, "update category set category = '$category',order_number = '$order_number' where id = $id ");
                if ($query) {
                    redirect('category.php');
                }
            }
        } else {
            $query = mysqli_query($conn, "insert into category (category,order_number,status) values('$category','$order_number','1') ");
            if ($query) {
                redirect('category.php');
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
                        <label for="exampleInputName1">Category Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Category Name" name="category" value="<?= (isset($assco['category'])) ? $assco['category'] : '' ?>" required="">
                        <span class="feild_error"><?= (isset($msg)) ? $msg : '' ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Order Number</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Order Number" name="order_number" value="<?= (isset($assco['order_number'])) ? $assco['order_number'] : '' ?>" required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_category"/>
                    <a href="category.php" class="btn btn-light">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>