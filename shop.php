<?php
require_once './header.php';
$category_dish = ' ';
$type = ' ';
$search = '';
$categorydish_assoc = array();
if (isset($_GET['category_dish']) && $_GET['category_dish'] != '') {
    $category_dish = get_safe_value($conn, $_GET['category_dish']);
    $categorydish_assoc = explode(":", $category_dish);
    unset($categorydish_assoc[0]);
    $implode = implode(',', $categorydish_assoc);
//pr($categorydish_assoc);
// pr($_GET);
}
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($conn, $_GET['type']);
}
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = get_safe_value($conn, $_GET['search']);
}

$array_type = ['veg', 'non-veg', 'booth'];
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?= SITE_PATH ?>index">Home</a></li>
                <li class="active">Food Ordering </li>
            </ul>
        </div>


    </div>

</div>
<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <?php
        if ($website_close == 1) {
            ?>
            <div class="alert alert-danger text-center"><?= $website_close_msg ?></div>
            <?php
        }
        ?>
        <div class="row flex-row-reverse">
            <div class="col-lg-9">

                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <div class="col-sm-6 col-12  mb-2">
                                <div class="card foodtype">
                                    <div class="card-body p-3">
                                        <?php
                                        foreach ($array_type as $list) {
                                            $checked = '';
                                            if ($list == $type) {
                                                $checked = "checked= 'checked' ";
                                            }
                                            ?>
                                            <?= ucfirst($list) ?>  <input <?= $checked ?>  onclick="setfoodtype('<?= $list ?>')" class="dish_radio" type="radio" name="type" value=" <?= $list ?> " />
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="row justify-content-md-end">
                                    <div class="col-md-6 col-sm-8 col-12 pr-sm-0 ">
                                        <input class="bg-light" type="text" placeholder="Search " name="search" id="search_str" required=""/>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-12 my-2 mt-sm-0 pl-sm-0 ">
                                        <button onclick="search_operation()" class="search_btn" type="button">Search</button>
                                    </div>
                                </div>


                            </div>


                        </div>

                        <div class="row">
                            <?php
                            $category_id = 0;
                            $dish_sql = "select * from dish where status = 1 ";

                            if ($category_dish != ' ') {
                                $dish_sql .= " and category_id in ($implode)  ";
                            }
                            if ($type != ' ' && $type != 'booth') {
                                $dish_sql .= " and type = '$type'  ";
                            }
                            if ($search != ' ') {
                                $dish_sql .= " and dish like '%$search%'  ";
                            }

                            $dish_sql .= " order by id desc";
                            // echo $dish_sql;
                            $dish_query = mysqli_query($conn, $dish_sql);
                            $dish_row = mysqli_num_rows($dish_query);
                            if ($dish_row > 0) {
                                while ($dish_assoc = mysqli_fetch_assoc($dish_query)) {
                                    ?>

                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="javascript:void(0)">
                                                    <img src="<?= SITE_DISH_IMAGE . $dish_assoc['image'] ?>" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h4>
                                                    <a href="javascript:void(0)">
                                                        <?= $dish_assoc['dish'] ?>
                                                        <?php
                                                        if ($dish_assoc['type'] == 'veg') {
                                                            ?>
                                                            <span class="text-success"><?= '(' . $dish_assoc['type'] . ')' ?></span>
                                                            <?php
                                                        } elseif ($dish_assoc['type'] == 'non-veg') {
                                                            ?>
                                                            <span class="text-danger"><?= '(' . $dish_assoc['type'] . ')' ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="text-primary"><?= '(' . $dish_assoc['type'] . ')' ?></span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </a>
                                                    <?= getDishRate($dish_assoc['id']) ?>

                                                </h4>

                                                <?php
                                                $sql = "select * from  dish_details where status = 1 and dis_id = '" . $dish_assoc['id'] . " ' ";
                                                $query = mysqli_query($conn, $sql);
                                                while ($dish_details_assoc = mysqli_fetch_assoc($query)) {
                                                    if ($website_close == 0) {
                                                        ?>
                                                        <div class="product-price-wrapper d-inline">
                                                            <input class="dish_radio" type="radio" name="radido_<?= $dish_assoc['id'] ?>" value="<?= $dish_details_assoc['id'] ?>" /><span><?= ucfirst($dish_details_assoc['attribute']) ?></span>
                                                            <span><?= $dish_details_assoc['price'] ?>Tk</span>
                                                        </div>
                                                        <?php
                                                        $qty = '';
                                                        $icon_class = "";
                                                        if (array_key_exists($dish_details_assoc['id'], $get_cart_data)) {
                                                            $qty = get_cart_data($dish_details_assoc['id']);
                                                            $icon_class = "fa fa-shopping-cart";
                                                            ?>
                                                            <span id="qtyadd_<?= $dish_details_assoc['id'] ?>" class="added_styl_icon"><i class="fa fa-shopping-cart"><small " class="ml-1"><?php echo $qty ?></small></i></span>
                                                            <?php
                                                        }
                                                        ?>
                                                        <span class="added_styl_icon"><i class=""><small id="qtyadd_<?= $dish_details_assoc['id'] ?>" class="ml-1 text-dark"></small></i></span>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <?php
                                            if ($website_close == 0) {
                                                ?>
                                                <div class="row qty_select">
                                                    <div class="col-12">
                                                        <select name="qty" id="qty_<?php echo $dish_assoc['id'] ?>" class="form-control qty_style mt-2 d-inline" >
                                                            <option value="0">Qty</option>
                                                            <?php
                                                            for ($i = 1; $i <= 10; $i++) {
                                                                ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="qty_style_icon"><i onclick="sent_cart('<?php echo $dish_assoc['id'] ?>', 'add')" class="fa fa-shopping-cart"></i></span>
                                                    </div>
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="alert alert-danger"><?= $website_close_msg ?></div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>


                                    <?php
                                }
                            } else {
                                $msg = "No Data Found";
                                if (isset($msg)) {
                                    ?>
                                    <div class="col-6 col-offset-3 mx-auto mt-5">
                                        <div class="   alert alert-danger text-center"><?= $msg ?></div>
                                    </div>

                                    <?php
                                }
                            }
                            ?>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq" class="category">
                                <?php
                                $link = $_SERVER['PHP_SELF'];
                                $page = explode("/", $link);
                                
                                
                                
                                
                                
                                
                                $page_link = end($page);
                                ?>
                                <li > <a  class="<?= (!isset($_GET['id']) && $page_link == 'shop.php') ? 'active_category' : '' ?>" href="shop.php">All Food</a> </li>
                                <?php
                                $category_query = mysqli_query($conn, "select * from category where status = 1 ");
                                while ($category_assoc = mysqli_fetch_assoc($category_query)) {
                                    $active = '';
                                    if ($category_id == $category_assoc['id']) {
                                        $active = 'active_category';
                                    }
                                    $checked = '';
                                    if (in_array($category_assoc['id'], $categorydish_assoc)) {
                                        $checked = "checked = 'checked' ";
                                    }
                                    ?>
                                    <li> <input <?= $checked ?>  onclick="check_category(<?= $category_assoc['id'] ?>)" class="category_check" type="checkbox" name="category_check[]" value="<?= $category_assoc['id'] ?>" /><span class="category_span"><?= $category_assoc['category'] ?></span> </li>


                                    <?php
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form  method="GET" id="categoryidform">
    <input type="text" name="category_dish"  id="category_dish" value= "<?= $category_dish ?> " />


</form>
<form  method="GET" id="settype">
    <input type="text" name="type"  id="type" value= "<?= $type ?> " />
</form>
<form  method="GET" id="searchfrm">
    <input type="text" name="search"  id="search" value= "<?= $search ?> " />
</form>
<script type="text/javascript">
    function check_category(id) {
        var cat_dish = jQuery('#category_dish').val();
        var check = cat_dish.search(":" + id);
        if (check != '-1') {
            cat_dish = cat_dish.replace(":" + id, "")
        } else {
            cat_dish = cat_dish + ":" + id;
        }

        jQuery('#category_dish').val(cat_dish);
        jQuery('#categoryidform')[0].submit();
    }

    function setfoodtype(type) {
        jQuery('#type').val(type);
        jQuery('#settype')[0].submit();
    }
    function search_operation() {
        jQuery('#search').val(jQuery('#search_str').val());

        jQuery('#searchfrm')[0].submit();


        //alert(search);
        // jQuery('#settype')[0].submit();
    }

</script>
<?php require_once './footer.php'; ?>