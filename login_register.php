<?php require_once './header.php';
if(isset($_GET['referral_code']) && $_GET['referral_code'] !=''){
    $_SESSION['from_referral_code'] = get_safe_value($conn, $_GET['referral_code']);
}
//pr($_SESSION);
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                        <a data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form id="login_form" method="post">
                                        <input type="email" name="email" placeholder="Email" required="">
                                        <input type="password" name="password" placeholder="Password" required="">
                                        <input name="type" type="hidden" value="login">
                                        <input name="checkout_login" type="hidden" value=" ">
                                        <div class="button-box">
                                            <div class="login-toggle-btn d-inline">
                                                <a href="forgot_password">Forgot Password?</a>
                                            </div>
                                            <button id="login_submit_button" type="submit"><span>Login</span></button>
                                            <div id="login_error" class="feild_error_login"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post" id="register_form">
                                        <input type="text" name="user-name" placeholder="Username">
                                        <input type="password" name="user-password" placeholder="Password">
                                        <input name="user-email" placeholder="Email" type="email">
                                        <div id="email_error" class="feild_error"></div>
                                        <input name="user-mobile" placeholder="Mobile" type="text">
                                        <input name="type" type="hidden" value="register">
                                        
                                        <div class="button-box" id="">
                                            <button id="submit_register" type="submit">Register</button>

                                        </div>
                                        <div class="text-success" id="success_field"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once './footer.php'; ?>