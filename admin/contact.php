<?php
require_once './header.php';
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($conn, $_GET['id']);

        $query = mysqli_query($conn, "delete from contact  where id = '$id' ");
        if ($query) {
            redirect('contact.php');
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
                                <th>Subject</th>
                                <th>Message</th>  
                                <th>Send Date</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select * from contact ");
                            $i = 1;
                            while ($assoc = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $assoc['name'] ?></td>
                                    <td><?= $assoc['email'] ?></td>
                                    <td><?= $assoc['mobile'] ?></td>
                                    <td><?= $assoc['subject'] ?></td>
                                    <td><?= $assoc['message'] ?></td>
                                    <td>
                                        <?= date('d-M-Y' . strtotime($assoc['insertdate'])) ?>

                                    </td>
                                    <td>
                                        <?php
                                        ?>
                                        <label class="badge badge-danger "><a class="text-decoration-none text-light" href="?id=<?= $assoc['id'] ?> &type=delete"><i class="fa fa-trash"></i></a></label>
                                                <?php
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