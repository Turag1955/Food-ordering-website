<?php require_once './header.php';
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form id="forgot_password_form" method="post" >
                                        <input type="email" name="email" placeholder="Email" required="">
                                        <input name="type" type="hidden" value="forgot_password">
                                        <div class="button-box">
                                            <button id="forgot_submit_button" type="submit"><span>Submit</span></button>
                                            <a class="" href="login_register" id="login_submit_button"><span>Login</span></a>
                                            <div id="forgot_error" class="feild_error_login"></div>
                                            <div id="forgot_success" class="text-success"></div>
                                        </div>
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