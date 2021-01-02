<?php
require_once './header.php';
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
    if ($type == 'status') {
        $id = get_safe_value($conn, $_GET['id']);
        $operation = get_safe_value($conn, $_GET['operation']);
        $status = 0;
        if ($operation == 'active') {
            $status = 1;
        }
        $query = mysqli_query($conn, "update coupon set status = '$status' where id = '$id' ");
        if ($query) {
            redirect('coupon.php');
        }
    }
    if ($type == 'delete') {
        $id = get_safe_value($conn, $_GET['id']);
        $query = mysqli_query($conn, "delete from coupon  where id = '$id' ");
    }
}
?>
<div class="card">
    <div class="card-body">
        <a href="add_coupon.php"> <h1 class="card-title">Add Coupon</h1></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Name </th>
                                <th>Type </th>
                                <th> value</th>
                                <th>Min value </th>
                                 <th>Expire Date  </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select * from coupon ");
                            $i = 1;
                            while ($assoc = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $assoc['coupon_name'] ?></td>
                                    <td><?= $assoc['coupon_type'] ?></td>
                                    <td><?= $assoc['coupon_value'] ?></td>
                                    <td><?= $assoc['cat_min_value'] ?></td>
                                    <td><?= $assoc['expire_date'] ?></td>
                                    <td>
                                        <?php
                                        if ($assoc['status'] == 1) {
                                            ?>
                                            <label class="badge badge-success "><a class="text-decoration-none text-light" href="?id=<?= $assoc['id'] ?> &type=status&operation=deactive"><i class="fa fa-check"></i></a></label>
                                            <?php
                                        } else {
                                            ?>
                                            <label class="badge badge-danger "><a class="text-decoration-none text-light" href="?id=<?= $assoc['id'] ?>&type=status&operation=active"><i class="fa fa-close"></i></a></label>
                                            <?php
                                        }
                                        ?>
                                        <label class="badge badge-danger "><a class="text-decoration-none text-light" href="?id=<?= $assoc['id'] ?>&type=delete"><i class="fa fa-trash"></i></a></label>
                                        <label class="badge badge-info "><a class="text-decoration-none text-light" href="add_coupon.php?id=<?= $assoc['id'] ?>&type=update"><i class="fa fa-pencil"></i></a></label>

                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>