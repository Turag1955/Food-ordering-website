<?php
require_once './header.php';
$errors = [];
if (isset($_POST['submit_dish'])) {

    $heading = get_safe_value($conn, $_POST['heading']);
    $sub_heading = get_safe_value($conn, $_POST['sub_heading']);
    $add_link = get_safe_value($conn, $_POST['add_link']);
    $link_text = get_safe_value($conn, $_POST['link_text']);
    $order_number = get_safe_value($conn, $_POST['order_number']);

    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_size = $image['size'];
    $image_tmp = $image['tmp_name'];
   // prx($_FILES['image']);

    $explode = explode('.', $image_name);
    $end = strtolower(end($explode));
    $extantion = ['jpg', 'jpeg', 'png'];


    if (!in_array($end, $extantion)) {
        $errors [] = 'please upload image with jpg/jpeg/png';
    }
    if ($image_size > 1024 * 1024 * 3) {
        $errors [] = 'please upload image with 3Mb';
    }

    $newimagename = 'food'.'-' . uniqid() . '.' . $end;
    
    if (!$errors) {
        $query = mysqli_query($conn, "insert into banner (image,heading,sub_heading,link,link_text,order_number,status) values('$newimagename','$heading','$sub_heading','$add_link','$link_text','$order_number','1')");



        if ($query) {
            move_uploaded_file($image_tmp, SERVER_BANNER_IMAGE . $newimagename);
            redirect('banner.php');
        }
    }
}


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
                        <label for="exampleInputName1">Image</label>
                        <input type="file" class="form-control" id="exampleInputName1" name="image"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Heading </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Heading " name="heading" value="<?= (isset($heading)) ? $heading : '' ?>"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Sub Heading </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Sub Heading " name="sub_heading" value="<?= (isset($sub_heading)) ? $sub_heading : '' ?>"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Link </label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Link " name="add_link" value="<?= (isset($add_link)) ? $add_link : '' ?>"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Link Text</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Link Text " name="link_text" value="<?= (isset($link_text)) ? $link_text : '' ?>"  required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Order Number</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Order Number " name="order_number" value="<?= (isset($order_numbert)) ? $order_numbert : '' ?>"  required="">
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-primary mr-2"  name="submit_dish"/>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>