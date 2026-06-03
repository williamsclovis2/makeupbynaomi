<div class="card-box shadow-none p-4">
    <div class="p-2">
        <div class="text-center mt-4 mob-space">
            <a href="index" class="logo logo-dark">
                <span class="">
                <!-- <span class="logo-lg"> -->
                    <img src="<?= DNADMIN ?>/assets/images/logo-main.png" alt="" height="160">
                </span>
            </a> 

            <a href="index " class="logo logo-light">
                <span class="">
                    <img src="<?= DNADMIN ?>/assets/images/logo-main.png" alt="" height="160">
                </span>
            </a>
        </div>

        <h4 class="font-size-18 mt-5  w-title">Forgot your password !</h4>
        <p class="text-muted  w-paragraphe">Enter your email address and we'll send you an email with instructions to reset your password. </p>
        <form method="post" id="recover_form">
                <?php if(Input::get('response','get') != 'success'){?>
                    <?php if(Input::get('response','get') == 'errors'){?>
                        <h6 class="st-subtitle mb-2 mt-2 error bg-danger" style="padding: 5px; color: #fff;"><span class="">Username not found. For any inquires, please contact the administrator.</span></h6>
                    <?php }elseif(Input::get('response','get') == 'success'){?>
                        <h6 class="st-subtitle error bg-danger" style="color: #4fab90"><span class="">Check your email now to recover your password.</span></h6>
                    <?php }else{?>
                            <h6 id="error_message" style='display: none'><span id="error_lo"></span><span id="no_visible"> Username not found. For any inquires, please contact the administrator</span></h6>
                    <?php }?>

                <div class="mb-3">
                    <label class="form-label" for="username">Email Adress</label>
                    <input  class="form-control" id="recover-email"  name="recover-email" type="email" placeholder=" Email address" required>
                </div>
                <div class="mb-3 row">
                    <input type="hidden" class="hidden" name="request" value="recover-login" />
                    <input type="hidden" class="hidden" name="webToken" value="true" />
                    <div class="col-sm-6 ">
                        <button class="btn btn-primary w-md waves-effect waves-light"  id="recoverValidBtn" data-fieldset="#recover_form" name="recoverValidBtn" type="submit">  Submit</button>
                        <?php if(isset($form->ERRORS_SCRIPT['recover-email'])){?>
                            <script>
                                $(document).ready(function(){
                                    $('#recover-email').addClass('error');
                                });
                            </script>
                        <?php }?>
                    </div>
                </div>
                <?php }else{?> 
                    <h6 class="st-subtitle error bg-danger" style="color: #4fab90; font-size: 15px"><span class="">Check your email now to recover your password.</span></h6>
                    <div class="text-center" style="padding: 10px 20px 20px 20px; color: #c0c0c0">
                        <i class="glyphicon glyphicon-envelope" style="font-size: 100px;"></i> 
                    </div>
                <?php }?>

                <div class="mb-3 pt-3 mt-8 mb-0 row">
                    <div class="col-12 mt-3">
                        <a href="#" class="forget-pw"><i class="mdi mdi-lock"></i> Back to login</a>
                    </div>
                </div>

        </form>

    <!-- <div class="mt-1 pt-1 text-center">
        <p>© <script>document.write(new Date().getFullYear())</script> Barclay Nails </p>
    </div> -->

    </div>
</div>