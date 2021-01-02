<?php
require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';
$total_amount = 0;
$get_order_details = get_order_details(2);
foreach ($get_order_details as $val) {
    $total_amount = ($total_amount + ($val['qty'] * $val['price']));
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Billy - Food & Drink eCommerce</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">

            body{
                font-family:'Rubik', sans-serif;

            }
            h1{
                text-align: center;
                color: #615f5f;
            }
            .container {
                width: 100%;
                margin-right: auto;
                margin-left: auto;
            }
            .wrapper {
                margin: 0 auto;
                background: #e6e3e373;
                width: 42%;
                padding: 46px;
            }
            .name{
                margin: 0;
            }
            .color-p{
                color: #615f5f;
            }
            .title{
                margin: 0;
                margin-top: 5px;
                color: #615f5f;
            }
            .order_info{
                background: #ddd;
                padding: 12px 20px;
                margin: 12px 0px;
            }

            .pd{
                margin: 0;
                margin-bottom: 5px;
            }
            .table {
                width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
            }
            thead {
                display: table-header-group;
                vertical-align: super;
                border-color: inherit;
            }
            tr {
                display: table-row;
                vertical-align: inherit;
                border-color: inherit;
            }
            table td {
                border: none;
                border-bottom: 1px solid #e8e9ef;
                color: #615f5f;
                font-size: 12px;
                font-weight: 400;
                padding: .75em 1.25em;
                text-transform: uppercase;
            }
            table th {
                border: none;
                border-bottom: 1px solid #e8e9ef;
                color: #000000;
                font-size: 12px;
                font-weight: 400;
                padding: .75em 1.25em;
                text-transform: uppercase;
                text-align: start;

            }
            .total{
                color: black;
                font-weight: bold;
            }
            .support_link{
                text-decoration: none;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="wrapper">
                <div>
                    <h1>Billy Food orderning</h1>
                </div>
                <div>
                    <h2 class="name">Hi <?= ucfirst($_SESSION['user_name']) ?></h2>
                    <p class="title">This is an invoice for your recent purchase</p>
                </div>    
                <div class="order_info">
                    <p class="pd">Amount Due: <span><?= $total_amount ?> Tk</span> </p>
                    <p class="pd">Order Id: <span>#<?= $val['order_id'] ?></span> </p>
                </div>
                <table class="table">
                    <thead>
                    <th>Food</th>
                    <th>Qty</th>
                    <th>Price</th>

                    </thead>
                    <tbody>
                        <?php
                        foreach ($get_order_details as $val) {
                            $total_amount = ($total_amount + ($val['qty'] * $val['price']));
                            ?>
                            <tr>
                                <td><?= $val['dish'] ?></td>
                                <td><?= $val['qty'] ?> </td>
                                <td><?= $val['qty'] * $val['price'] ?> Tk</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="total">Total</td>
                            <td colspan="1" class="total"><?= $total_amount ?> Tk</td>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <p class="color-p">If you have any question about this invoice.simply replay to this email or reach out to our <a class="support_link" href="foododer.com"> our support team</a> for help.</p>
                </div>
                <div>
                    <p class="title">Cheers,</p>
                    <p class="title">Food Odering</p>
                </div>
            </div>
        </div>

    </body>
</html>