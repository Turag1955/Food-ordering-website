<?php

function pr($str) {
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}

function prx($str) {
    echo '<pre>';
    print_r($str);
    die();
}

function get_safe_value($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}

function redirect($page) {
    ?>
    <script type="text/javascript">
        window.location.href = '<?= $page ?>';
    </script>
    <?php
    die();
}

function random_str() {
    $str = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz";
    $str_shuffle = str_shuffle($str);
    return $substr = substr($str_shuffle, 0, 15);
}

function get_insert_cart_data($dish_details_id, $qty) {
    if (isset($_SESSION['user_id'])) {
        $uid = $_SESSION['user_id'];
        global $conn;
        $res = mysqli_query($conn, "select * from dish_cart where user_id = $uid and dish_details_id = $dish_details_id ");
        $check_row = mysqli_num_rows($res);
        if ($check_row > 0) {
            $assoc = mysqli_fetch_assoc($res);
            $id = $assoc['id'];
            $query = mysqli_query($conn, "update dish_cart set qty = $qty where id = $id ");
        } else {
            $query = mysqli_query($conn, "insert into dish_cart (user_id,dish_details_id,qty) values('$uid','$dish_details_id','$qty') ");
        }
    } else {
        $_SESSION['cart'][$dish_details_id]['qty'] = $qty;
    }
}

function get_user_data() {
    $user_info = [];
    $uid = $_SESSION['user_id'];
    global $conn;
    $res = mysqli_query($conn, "select * from dish_cart where user_id = $uid ");
    while ($assoc = mysqli_fetch_assoc($res)) {
        $user_info[] = $assoc;
    }
    return $user_info;
}

function get_cart_data($dish_details_id = '') {
    $cartArr = [];
    if (isset($_SESSION['user_id'])) {
        $get_user_data = get_user_data();
        foreach ($get_user_data as $val) {
            $cartArr[$val['dish_details_id']]['qty'] = $val['qty'];
            $dishdetails_id = $val['dish_details_id'];
            $get_addToCart = get_addToCart($dishdetails_id);
            $cartArr[$val['dish_details_id']]['dish'] = $get_addToCart['dish'];
            $cartArr[$val['dish_details_id']]['price'] = $get_addToCart['price'];
            $cartArr[$val['dish_details_id']]['image'] = $get_addToCart['image'];
            $cartArr[$val['dish_details_id']]['dish_status'] = $get_addToCart['dish_status'];
            $cartArr[$val['dish_details_id']]['dish_details_status'] = $get_addToCart['dish_details_status'];
        }
    } else {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $key => $list) {
                $get_addToCart = get_addToCart($key);
                $cartArr[$key]['qty'] = $list['qty'];
                $cartArr[$key]['dish'] = $get_addToCart['dish'];
                $cartArr[$key]['price'] = $get_addToCart['price'];
                $cartArr[$key]['image'] = $get_addToCart['image'];
                $cartArr[$key]['dish_status'] = $get_addToCart['dish_status'];
                $cartArr[$key]['dish_details_status'] = $get_addToCart['dish_details_status'];
// pr($get_addToCart);
            }
        }
    }
    if ($dish_details_id != '') {
        return $cartArr[$dish_details_id]['qty'];
    } else {
        return $cartArr;
    }
}

function get_addToCart($id) {
    global $conn;
    $price = mysqli_query($conn, "select dish.dish,dish.image,dish.status as dish_status,dish_details.id,dish_details.price,dish_details.status as dish_details_status  from  dish,dish_details where  dish.id = dish_details.dis_id and dish_details.id = $id  ");
    return $cart_assoc = mysqli_fetch_assoc($price);
}

function getAllDishStatus() {
    global $conn;
    $statusarr = [];
    if (isset($_SESSION['user_id'])) {
        $get_user_data = get_user_data();
        foreach ($get_user_data as $val) {
            $statusarr[] = $val['dish_details_id'];
        }
    } else {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $key => $list) {
                $statusarr[] = $key;
            }
        }
    }
    foreach ($statusarr as $id) {
        $query = mysqli_query($conn, "select dish.id,dish.status as dish_status,dish_details.status as dish_details_status from dish,dish_details where dish.id = dish_details.dis_id and dish_details.id = $id ");
        $assoc = mysqli_fetch_assoc($query);
        $dish_id = $assoc['id'];
        if ($assoc['dish_status'] == 0) {
            $query_detais = mysqli_query($conn, "select id from dish_details where dis_id = $dish_id ");
            while ($assoc_details = mysqli_fetch_assoc($query_detais)) {
                delete_cart($assoc_details['id']);
            }
        }
        if ($assoc['dish_details_status'] == 0) {
            delete_cart($id);
        }
    }
}

function delete_cart($dish_details_id) {
    if (isset($_SESSION['user_id'])) {
        global $conn;
        $delete = mysqli_query($conn, "delete from dish_cart where dish_details_id =  $dish_details_id and user_id =" . $_SESSION['user_id']);
    } else {
        unset($_SESSION['cart'][$dish_details_id]);
    }
}

function emptyCart() {
    if (isset($_SESSION['user_id'])) {
        global $conn;
        $delete = mysqli_query($conn, "delete from dish_cart where  user_id =" . $_SESSION['user_id']);
    } else {
        unset($_SESSION['cart']);
    }
}

function useInfo() {
    $uid = $_SESSION['user_id'];
    $user_info = [];
    global $conn;
    $res = mysqli_query($conn, "select * from users where id = $uid ");
    $assoc = mysqli_fetch_assoc($res);
    $user_info['name'] = $assoc['name'];
    $user_info['email'] = $assoc['email'];
    $user_info['mobile'] = $assoc['mobile'];
    $user_info['referral_code'] = $assoc['referral_code'];

    return $user_info;
}

function get_order_details($order_id) {
    $user_info = [];
    global $conn;
    $order_detalis_query = mysqli_query($conn, "SELECT order_details.*,dish.dish,dish.image
                                                                        FROM order_details,dish,dish_details
                                                                        WHERE order_details.order_id = $order_id and
                                                                        order_details.dis_details_id = dish_details.id AND 
                                                                        dish_details.dis_id = dish.id  ");
    while ($order_detalis = mysqli_fetch_assoc($order_detalis_query)) {
        $user_info[] = $order_detalis;
    }
    return $user_info;
}

function checkoutEmailHtml($order_id) {
    $total_amount = 0;
    $get_order_details = get_order_details($order_id);
    foreach ($get_order_details as $val) {
        $total_amount = ($total_amount + ($val['qty'] * $val['price']));
    }
    $html = '
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
                font-family:"Rubik", sans-serif;

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
                    <h2 class="name">Hi ' . ucfirst($_SESSION['user_name']) . '</h2>
                    <p class="title">This is an invoice for your recent purchase</p>
                </div>    
                <div class="order_info">
                    <p class="pd">Amount Due: <span>' . $total_amount . ' Tk</span> </p>
                    <p class="pd">Order Id: <span>#  ' . $val['order_id'] . ' </span> </p>
                </div>
                <table class="table">
                    <thead>
                    <th>Food</th>
                    <th>Qty</th>
                    <th>Price</th>

                    </thead>
                    <tbody>';
    $total_amount = 0;
    foreach ($get_order_details as $val) {
        $total_amount = ($total_amount + ($val['qty'] * $val['price']));

        $html .= '<tr>
                                <td> ' . $val['dish'] . ' </td>
                                <td> ' . $val['qty'] . '  </td>
                                <td>  ' . $val['qty'] * $val['price'] . ' Tk</td>
                            </tr>';
    }
    $html .= '</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="total">Total</td>
                            <td colspan="1" class="total">' . $total_amount . ' Tk</td>
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
</html>';
    return $html;
}

function dateFormate($date) {
    $strto = strtotime($date);
    return date('d-M-Y h:m', $strto);
}

function getSetting() {
    global $conn;
    $res = mysqli_query($conn, "select * from setting where id = 1 ");
    $setting_info = mysqli_fetch_assoc($res);
    return $setting_info;
}

function rankingHtml($dish_details_id, $order_id) {
    $rankArr = ['good', 'bed', 'very testy', 'yammi'];
    $html = '<select class="form-control ranking_stayle" name="ranking" id="ranking' . $dish_details_id . '" onchange=select_rank(' . $dish_details_id . ',' . $order_id . ') >';
    $html .= '<option value="">Select Ranking</option>';
    foreach ($rankArr as $key => $val) {
        $index = $key + 1;
        $html .= '<option value=' . $index . '>' . $val . '</option>';
    }
    $html .= '</select>';
    echo $html;
//return $html;
}

function getRating($dish_details_id, $order_id) {
    global $conn;
    $sql = "select * from rating where order_id = '$order_id' and dish_details_id = '$dish_details_id' ";
//die();
    $res = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($res);
    if ($row > 0) {
        $assoc = mysqli_fetch_assoc($res);
        $rating = $assoc['rating'];
        $rankArr = ['', 'good', 'bed', 'very testy', 'yammi'];
        echo '<div>Feedback  <span class="feedback_style">' . $rankArr[$rating] . '</span> </div>';
    } else {
        rankingHtml($dish_details_id, $order_id);
    }
}

function getDishRate($dish_id) {

    global $conn;
    $sql = "select id  from dish_details where dis_id =  $dish_id";
//die();
    $res = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($res);
    $str = ' ';
    if ($row > 0) {
        while ($assoc = mysqli_fetch_assoc($res)) {
            $str .= "dish_details_id = " . $assoc['id'] . " or ";
        }
        $str = rtrim($str, " or");
        $sql = "select sum(rating) as rating, count(*) as total  from rating where $str ";
        $res = mysqli_query($conn, $sql);
        $assoc = mysqli_fetch_assoc($res);
        if ($assoc['total'] > 0) {
            $totalrating = floatval($assoc['rating'] / $assoc['total']);
            echo '<span class="text-warning"><i class="fa fa-star">' . $totalrating . '</i></span>';
        }
    }
}

function insertWalletData($uid, $wallet_amt, $type, $message, $payment_id = '') {
    global $conn;
    $res = mysqli_query($conn, "insert into wallet (user_id,wallet_amt,type,message,payment_id) values('$uid','$wallet_amt','$type','$message','$payment_id') ");
}

function getWalletTotalAmount($uid) {
    global $conn;
    $in = 0;
    $out = 0;
    $wallet_query = mysqli_query($conn, "SELECT * from wallet where user_id = $uid ");
    while ($assoc = mysqli_fetch_assoc($wallet_query)) {
        if ($assoc['type'] == 'in') {
            $in = $in + $assoc['wallet_amt'];
        }
        if ($assoc['type'] == 'out') {
            $out = $out + $assoc['wallet_amt'];
        }
    }
    return $in - $out;
}

function getWallet($uid) {
    global $conn;
    $data = [];
    $wallet_query = mysqli_query($conn, "SELECT * from wallet where user_id = $uid ");
    while ($assoc = mysqli_fetch_assoc($wallet_query)) {
        $data[] = $assoc;
    }
    return $data;
}

function getSale($start, $end) {
    global $conn;
    $sql = "SELECT SUM(final_price) as total FROM order_master WHERE order_status = 5 and insertdate BETWEEN '$start' and '$end' ";
    $query = mysqli_query($conn, $sql);
    while ($assoc = mysqli_fetch_assoc($query)) {
        return $assoc['total'];
    }
}
?>