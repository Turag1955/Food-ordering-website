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
        $query = mysqli_query($conn, "update users set status = '$status' where id = '$id' ");
        if ($query) {
            redirect('users.php');
        }
    }
}
?>
<div class="card">
    <div class="card-body">
        <a href="add_category.php"> <h1 class="card-title">Add Category</h1></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Name </th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Action</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select * from users ");
                            $i = 1;
                            while ($assoc = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $assoc['name'] ?></td>
                                    <td><?= $assoc['email'] ?></td>
                                    <td><?= $assoc['mobile'] ?></td>
                               

                                    <td>
                                        <label class="badge badge-primary ">  <a class=" text-decoration-none text-light" href="add_money?id=<?= $assoc['id'] ?>">Add money</a></label>
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