<?php
require_once './header.php';
if (isset($_GET['id']) && $_GET['id'] != '') {
    $id = get_safe_value($conn, $_GET['id']);
    $query = mysqli_query($conn, "select dish.*,dish_details.attribute,dish_details.price from dish,dish_details where dish_details.dis_id  =  dish.id and dish.id=$id");
    if (mysqli_num_rows($query) > 0) {
        $assoc = mysqli_fetch_assoc($query);
        $category_id = $assoc['category_id'];
        $dish = $assoc['dish'];
        $dis_details = $assoc['dish_details'];
        $type = $assoc['type'];
        $user_image = $assoc['image'];
    }
}
if (isset($_GET['details_id']) && $_GET['details_id'] != '') {
    $id = get_safe_value($conn, $_GET['id']);
    $details_id = get_safe_value($conn, $_GET['details_id']);
    $dish_deteails_delete = mysqli_query($conn, "delete from dish_details where id = $details_id");
    if ($dish_deteails_delete) {
        redirect('update_dish.php?id=' . $id);
    }
}
$errors = [];
if (isset($_POST['submit_dish'])) {
    $category_id = get_safe_value($conn, $_POST['category_id']);
    $dish = get_safe_value($conn, $_POST['dish']);
    $dis_details = get_safe_value($conn, $_POST['dis_details']);
    $type = get_safe_value($conn, $_POST['type']);




    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_size = $image['size'];
    $image_tmp = $image['tmp_name'];

    if ($image_name != '') {
        $explode = explode('.', $image_name);
        $end = strtolower(end($explode));
        $extantion = ['jpg', 'jpeg', 'png'];

        if (!in_array($end, $extantion)) {
            $errors [] = 'please upload image with jpg/jpeg/png';
        }
        if ($image_size > 1024 * 1024 * 3) {
            $errors [] = 'please upload image with 3Mb';
        }
        if (!$errors) {
            $newimagename = $dish . '-' . uniqid() . '.' . $end;
        }
    } else {
        $newimagename = $user_image;
    }

    if (!$errors) {
        $query = mysqli_query($conn, "update dish set category_id ='$category_id',dish = '$dish',dish_details = '$dis_details',type ='$type', image = '$newimagename' where id = $id");

        $attributearr = $_POST['attribute'];
        $pricearr = $_POST['price'];
        $statusarr = $_POST['status'];
        $dish_details_idarr = $_POST['dish_details_id'];
        foreach ($attributearr as $key => $val) {
            $attribute = $val;
            $price = $pricearr[$key];
            $status = $statusarr[$key];
            if (isset($dish_details_idarr[$key])) {
                $dish_details_id = $dish_details_idarr[$key];
                $dish_ditails_update = mysqli_query($conn, "update dish_details set attribute = '$attribute',price= '$price',status='$status' where id = $dish_details_id  ");
            } else {
                $dish_details_query = mysqli_query($conn, "insert into dish_details (dis_id,attribute,price,status) values('$id','$attribute','$price','$status')");
            }
        }
        if ($query) {
            move_uploaded_file($image_tmp, SERVER_DISH_IMAGE . $newimagename);
            redirect('dish.php');
        }
    }
}

$query = mysqli_query($conn, "select * from category where status = 1 ");
$type_array = ['veg', 'non-veg'];
?>
<div class="row">
    <h1 class="card-title ml10">Basic form elements</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php
                    }
                }
                ?>
                <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName1">Category</label>
                        <select name="category_id" id="" class="form-control" required="">
                            <option value="">------</option>
                            <?php
                            while ($category = mysqli_fetch_assoc($query)) {
                                if ($category_id == $category['id']) {
                                    ?>
                                    <option selected="" value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Type</label>
                        <select name="type" id="" class="form-control" required="">
                            <option value="">------</option>
                            <?php
                            foreach ($type_array as $list) {

                                if ($type == $list) {
                                    ?>
                                    <option selected="" value="<?= $list ?>"><?= strtoupper($list) ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option  value="<?= $list ?>"><?= strtoupper($list) ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Dish</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Dish " name="dish" value="<?= (isset($dish)) ? $dish : '' ?>" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Dish Details  </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Dish Details  " name="dis_details" value="<?= (isset($dis_details)) ? $dis_details : '' ?>"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">image </label>
                        <input type="file" class="form-control" id="exampleInputName1"  name="image" >
                    </div>
                    <?php
                    $dish_details_query = mysqli_query($conn, "select * from dish_details where dis_id  = $id");
                    $i = 1;
                    if (mysqli_num_rows($dish_details_query) > 0) {
                        while ($dish_details_assoc = mysqli_fetch_assoc($dish_details_query)) {
                            $attribute = $dish_details_assoc['attribute'];
                            $price = $dish_details_assoc['price'];
                            $dis_details_id = $dish_details_assoc['id'];
                            $status = $dish_details_assoc['status'];
                            ?>
                            <div class="row" id="dish_box">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Attribute </label>
                                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Attribute  " name="attribute[]" value="<?= (isset($attribute)) ? $attribute : '' ?>"  required="">

                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Price </label>
                                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Price " name="price[]" value="<?= (isset($price)) ? $price : '' ?>"  required="">
                                        <input type="hidden" name="dish_details_id[]" value="<?= $dis_details_id ?>" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Status </label>
                                        <select name="status[]" id="exampleInputName1" class="form-control">
                                            <option>Select status</option>
                                            <?php
                                            if ($status == 1) {
                                                ?>
                                                <option selected="" value="1">Active</option>
                                                <option value="0">Deactive</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="1">Active</option>
                                                <option selected="" value="0">Deactive</option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <?php
                                if ($i != 1) {
                                    ?>
                                    <div class="col-2"> 
                                        <div class="form-group"> 
                                            <br />
                                            <button type="button" class="btn btn-danger mr-2" onclick="db_row_remove('<?= $dis_details_id ?>')" > Remove</button>
                                        </div> 
                                    </div>
                                    <?php
                                }
                                ?>


                            </div>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                    <div id="more">

                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_dish"/>
                    <input onclick="add_more()" type="button"  value="Add More" class="btn btn-danger mr-2"  />
                </form>
            </div>
        </div>
    </div>

</div>
<?php require_once './footer.php'; ?>