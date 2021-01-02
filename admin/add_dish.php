<?php
require_once './header.php';
$errors = [];
if (isset($_POST['submit_dish'])) {

    $category_id = get_safe_value($conn, $_POST['category_id']);
    $dish = get_safe_value($conn, $_POST['dish']);
    $dis_details = get_safe_value($conn, $_POST['dis_details']);
    $type = get_safe_value($conn, $_POST['type']);

    $query = mysqli_query($conn, "select * from dish where status = 1 and dish = '$dish' ");
    if (mysqli_num_rows($query) > 0) {
        $errors [] = 'This dish allready exits';
    } else {


        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_size = $image['size'];
        $image_tmp = $image['tmp_name'];

        $explode = explode('.', $image_name);
        $end = strtolower(end($explode));
        $extantion = ['jpg', 'jpeg', 'png'];


        if (!in_array($end, $extantion)) {
            $errors [] = 'please upload image with jpg/jpeg/png';
        }
        if ($image_size > 1024 * 1024 * 3) {
            $errors [] = 'please upload image with 3Mb';
        }

        $newimagename = $dish . '-' . uniqid() . '.' . $end;
        if (!$errors) {
            $query = mysqli_query($conn, "insert into dish (category_id,dish,dish_details,type,image,status) values('$category_id','$dish','$dis_details','$type','$newimagename','1')");

            $did = mysqli_insert_id($conn);
            $attributearr = $_POST['attribute'];
            $pricearr = $_POST['price'];
            $statusarr = $_POST['status'];
            foreach ($attributearr as $key => $val) {
                $attribute = $val;
                $price = $pricearr[$key];
                $status = $statusarr[$key];
                $dish_details_query = mysqli_query($conn, "insert into dish_details (dis_id,attribute,price,status) values('$did','$attribute','$price','$status')");
            }

            if ($query && $dish_details_query) {
                move_uploaded_file($image_tmp, SERVER_DISH_IMAGE . $newimagename);
                redirect('dish.php');
            }
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
                                    <option selected="" value="<?= $list ?>"><?= $list ?></option>
                                    <?php
                                } else {
                                    ?>
                                    <option value="<?= $list ?>"><?= $list ?></option>
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
                        <input type="file" class="form-control" id="exampleInputName1"  name="image"  required="">
                    </div>
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
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exampleInputName1">Status </label>
                                <select name="status[]" id="exampleInputName1" class="form-control">
                                    <option>Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div id="more">

                    </div>

                    <input type="submit"  value="Submit" class="btn btn-primary mr-3"  name="submit_dish"/>
                    <input onclick="add_more()" type="button"  value="Add More" class="btn btn-danger mr-2"  />

                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="add_more_id" value="1" />
</div>
<?php require_once './footer.php'; ?>