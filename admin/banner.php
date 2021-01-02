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
        $query = mysqli_query($conn, "update banner set status = '$status' where id = '$id' ");
        if ($query) {
            redirect('banner.php');
        }
    }
    if ($type == 'delete') {
        $id = get_safe_value($conn, $_GET['id']);
        $query = mysqli_query($conn, "delete from banner  where id = '$id' ");
    }
}
?>
<div class="card">
    <div class="card-body">
        <a href="add_banner.php"> <h1 class="card-title">Add Banner</h1></a>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th>Serial No.</th>
                                <th>Image </th>
                                <th>Heading</th>
                                <th>Sub Heading</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select * from banner");
                            $i = 1;
                            while ($assoc = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><a href="<?= SITE_BANNER_IMAGE . $assoc['image'] ?>"><img src="<?= SITE_BANNER_IMAGE . $assoc['image'] ?>" alt="" /></a></td>
                                   <td><?= $assoc['heading'] ?></td>
                                    <td><?= $assoc['sub_heading'] ?></td>
                                    <td><?= $assoc['link'] ?></td>
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
                                        <label class="badge badge-info "><a class="text-decoration-none text-light" href="update_banner.php?id=<?= $assoc['id'] ?>"><i class="fa fa-pencil"></i></a></label>

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