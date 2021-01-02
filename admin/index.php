<?php require_once './header.php'; ?>
<div class="row">

    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $start = date('Y-m-d') . ' 00:00:00';
                $end = date('Y-m-d') . ' 23:59:59';
                $getSale = getSale($start, $end)
                ?>
                <p class="dashboard_p"><?php echo $getSale ?>$</p>
                <div class="">
                    <h4 class="mt-4 text_color mb-0 text-primary">Total Sale</h4>
                    <small class="dashboard_title">Today</small>
                </div>
                <div class="text-right text-primary dashboard_icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $start = strtotime(date('Y-m-d'));
                $start = strtotime("-7 day", $start);
                $start = date('Y-m-d', $start);
                $end = date('Y-m-d') . ' 23:59:59';
                $getSale = getSale($start, $end)
                ?>
                <p class="dashboard_p"><?php echo $getSale ?>$</p>
                <div class="">
                    <h4 class="mt-4 text-warning mb-0">7 Days  Sale</h4>
                    <small class="dashboard_title">Last 7 days</small>
                </div>
                <div class="text-right text-primary dashboard_icon text-warning">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $start = strtotime(date('Y-m-d'));
                $start = strtotime("-30 day", $start);
                $start = date('Y-m-d', $start);
                $end = date('Y-m-d') . ' 23:59:59';
                $getSale = getSale($start, $end)
                ?>
                <p class="dashboard_p"><?php echo $getSale ?>$</p>
                <div class="">
                    <h4 class="mt-4 text_color mb-0 text-success">30 Days Sale</h4>
                    <small class="dashboard_title">Last 30 days</small>
                </div>
                <div class="text-right text-primary dashboard_icon text-success">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $start = strtotime(date('Y-m-d'));
                $start = strtotime("-365 day", $start);
                $start = date('Y-m-d', $start);
                $end = date('Y-m-d') . ' 23:59:59';
                $getSale = getSale($start, $end)
                ?>
                <p class="dashboard_p"><?php echo $getSale ?>$</p>
                <div class="">
                    <h4 class="mt-4 text_color mb-0 text-info">365 Days Sale</h4>
                    <small class="dashboard_title">Last 365 days</small>
                </div>
                <div class="text-right text-primary dashboard_icon text-info">
                    <i class="fa fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT COUNT(order_details.dis_details_id) as total,order_details.dis_details_id,dish_details.attribute,dish.dish
                            FROM order_details,dish,dish_details
                            WHERE  order_details.dis_details_id = dish_details.id AND dish_details.dis_id = dish.id 
                            GROUP by order_details.dis_details_id 
                            ORDER by COUNT(order_details.dis_details_id) DESC limit 1";
                $query = mysqli_query($conn, $sql);
                $assoc = mysqli_fetch_assoc($query);
                //prx($assoc);
                ?>
                <p class="dashboard_p d-inline"><?= ucfirst($assoc['dish']) ?> </p>
                <span class="dashboard_title"><?= $assoc['total'] ?> items</span>
                <div class="">
                    <h4 class="mt-4 text_color mb-0 text-success">Most Sale Food</h4>


                </div>

            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-4 col-12">
        <div class="card">
            <div class="card-body">
                <?php
                $sql = "SELECT COUNT(order_master.user_id),order_master.user_id,users.name
                            FROM users,order_master
                            WHERE order_master.user_id = users.id
                            GROUP by order_master.user_id
                            ORDER BY COUNT(order_master.user_id) DESC limit 1";
                $query = mysqli_query($conn, $sql);
                $assoc = mysqli_fetch_assoc($query);
                //prx($assoc);
                ?>
                <p class="dashboard_p"><?=$assoc['name']?></p>
                <div class="">
                    <h4 class="mt-4 text_color mb-0 text-info">Most Active User</h4>
                    <small class="dashboard_title"></small>
                </div>
                <div class="text-right text-primary dashboard_icon text-info">
                    <i class="fa fa-user"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<br /><br />
<div class="card">
    <div class="card-body">
        <small class="dashboard_title">Latest 5 order</small>
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
                                <th>Date</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT order_master.*,order_status.order_status as orderstatus
                                                                            FROM order_master,order_status 
                                                                            WHERE order_master.order_status = order_status.id  
                                                                            ORDER by order_master.id DESC limit 5");
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
                                    <td><?= dateFormate($assoc['insertdate']) ?></td>
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