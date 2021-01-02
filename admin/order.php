<?php
require_once './header.php';

?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="10">Serial No.</th>
                                <th>Customer Info </th>
                                <th>Address</th>  
                                <th>Payment type</th>  
                                <th>Payment status</th>  
                                <th>Order status</th>  
                                <th>Order Details</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT order_master.*,order_status.order_status as orderstatus
                                                                            FROM order_master,order_status 
                                                                            WHERE order_master.order_status = order_status.id  
                                                                            ORDER by order_master.id DESC");
                            $i = 1;
                            while ($assoc = mysqli_fetch_assoc($query)) {
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <p>Name- <?= ucfirst($assoc['name']) ?></p>
                                        <p>Email- <?= ucfirst($assoc['email']) ?></p>
                                        <p>Mobile- <?= $assoc['mobile'] ?></p>
                                    </td>
                                    <td>
                                        <p><?= ucfirst($assoc['address']) ?></p>
                                        <p><?= ucfirst($assoc['country']) ?></p>
                                        <p><?= $assoc['zip_code'] ?></p>
                                    </td>
                                    <td><?= $assoc['payment_type'] ?></td>
                                    <td class="text-warning"><?= $assoc['payment_status'] ?></td>
                                    <td class="text-info"><?= $assoc['orderstatus'] ?></td>
                                    <td><a href="order_details?id=<?= $assoc['id']?>" class="btn btn-primary">Order details</a></td>
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