<div class="card-box shadow-none p-4">
    <div class="p-2">
        <div class="text-center mt-4 mob-space">
            <a href="index" class="logo logo-dark">
                <span class="">
                <!-- <span class="logo-lg"> -->
                    <img src="<?= DNADMIN ?>/assets/images/logo-main.png" alt="" height="200">
                </span>
            </a> 

            <a href="#" class="logo logo-light">
                <span class="">
                    <img src="<?= DNADMIN ?>/assets/images/logo-main.png" alt="" height="160">
                </span>
            </a>
        </div>

        <h4 class="font-size-18 mt-5 text-center w-title">Welcome Back !</h4>
        <p class="text-muted text-center w-paragraphe">Login <i class="ti-unlock"></i> to continue to Barclay Nails </p>

        <form class="mt-4" method="post" id="login_form">
            <div class="row">
                <div class="error-message">
                     <?php if($form->ERRORS == true ){?>
                        <h6 class="st-subtitle error bg-danger"><span class="">Username or Password don't match, Please retry.</span></h6>
                    <?php }else{?>
                            <h6 id="error_message" style='display: none'><span id="error_lo"></span><span id="no_visible"> Username or Password don't match, Please retry.</span></h6>
                    <?php }?>
                </div>
            </div>

                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" class="form-control" id="login_username" name="login_username" required placeholder="Enter username">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="userpassword">Password</label>
                    <input type="password" class="form-control" id="login_password" name="login_password" required placeholder="Enter password">
                </div>

                <div class="mb-3 row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customControlInline">
                            <label class="form-check-label" for="customControlInline">Remember me</label>
                        </div>
                    </div>
                    <input type="hidden" class="hidden" name="request" value="user_login" />
                    <input type="hidden" class="hidden" name="webToken" value="true" />
                    <div class="col-sm-6 text-end">
                        <button class="btn btn-primary w-md waves-effect waves-light" id="loginValidBtn" data-fieldset="#login_form" name="loginValidBtn" type="submit"> <i class="ti-import"></i> Log In</button>
                        <?php if(isset($form->ERRORS_SCRIPT['username'])){?>
                            <script>
                                $(document).ready(function(){
                                    $('#login_username').addClass('error');
                                });
                            </script>
                        <?php }?>
                        <?php if(isset($form->ERRORS_SCRIPT['password'])){?>
                            <script>
                                $(document).ready(function(){
                                    $('#login_password').addClass('error');
                                });
                            </script>
                        <?php }?>
                    </div>
                </div>

                <div class="mb-3 pt-3 mt-8 mb-0 row">
                    <div class="col-12 mt-3">
                        <a href="<?=DNADMIN?>/login/forgotpassword" class="forget-pw"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                    </div>
                </div>

        </form>

    <!-- <div class="mt-1 pt-1 text-center">
        <p>© <script>document.write(new Date().getFullYear())</script> Barclay Nails </p>
    </div> -->

    </div>
</div>