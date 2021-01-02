<?php
require_once './config/database.php';
require_once './config/function.php';
require_once './config/coreConfig.php';
require_once './config/constant.php';

    $name = get_safe_value($conn, $_POST['name']);
    $email = get_safe_value($conn, $_POST['email']);
    $mobile = get_safe_value($conn, $_POST['mobile']);
    $subject = get_safe_value($conn, $_POST['subject']);
    $message = get_safe_value($conn, $_POST['message']);

    $contact_query = mysqli_query($conn, "insert into contact (name,email,mobile,subject,message) values('$name','$email','$mobile','$subject','$message') ");
    
   echo "Thanks for contact with us";
    

?>