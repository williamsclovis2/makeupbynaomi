<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Reset User Password</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-secondary" href="<?=DNADMIN?>/company/users/list">
                    <i class="mdi mdi-arrow-left me-2"></i> Back to Users
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<?php
// Display flash messages
if (Session::exists('success')) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle me-2"></i><strong>Success!</strong> ' . Session::flash('success') . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

if (Session::exists('errors')) {
    $errors = Session::flash('errors');
    if (is_array($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle me-2"></i><strong>Error!</strong> ' . $error . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        }
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle me-2"></i><strong>Error!</strong> ' . $errors . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

// Display form errors
if($form->ERRORS) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle me-2"></i><strong>Error!</strong> ' . 
            @$form->ERRORS_STRING . ' ' . 
            @$form->ERRORS_SCRIPT['password'][0] . ' ' . 
            @$form->ERRORS_SCRIPT['repassword'][0] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}
?>

<div class="row ">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-body col-md-6">
                <h4 class="card-title mb-4">
                    <i class="mdi mdi-lock-reset me-2"></i>Update Password
                </h4>
                
                <!-- User Info Alert -->
                <div class="alert alert-info mb-4" role="alert">
                    <i class="mdi mdi-information me-2"></i>
                    <strong>Updating password for:</strong> <?= $user_data->firstname . ' ' . $user_data->lastname ?> (<?= $user_data->email ?>)
                </div>

                <div class="card overflow-hidden">
                    <div class="card-body " style="padding: unset !important;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-3 form-card">
                                    <form method="POST" action="" class="mt-2">
                                        <input type="hidden" name="webToken" value="56">
                                        <input type="hidden" name="request" value="user-update">
                                        <input type="hidden" name="id" value="<?php echo $user_data->ID; ?>">
                                        <input type="hidden" name="token" value="true">
                                        <input type="hidden" name="task" value="user-update">

                                        <!-- Password Requirements Info -->
                                        <div class="alert alert-light border mb-4" role="alert">
                                            <h6 class="alert-heading mb-2">
                                                <i class="mdi mdi-shield-check-outline me-1"></i>Password Requirements:
                                            </h6>
                                            <ul class="mb-0" style="font-size: 13px;">
                                                <li>At least one uppercase letter</li>
                                                <li>At least one lowercase letter</li>
                                                <li>At least one number</li>
                                                <li>At least one special character</li>
                                                <li>Minimum 8 characters</li>
                                            </ul>
                                        </div>

                                        <!-- New Password -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-password">
                                                New Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input 
                                                    type="password" 
                                                    class="form-control passwordField" 
                                                    id="user-password" 
                                                    name="user-password" 
                                                    placeholder="Enter new password" 
                                                    required
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    id="togglePassword"
                                                >
                                                    <i class="mdi mdi-eye-outline" id="toggleIcon"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Must include uppercase, lowercase, special characters, and numbers
                                            </small>
                                        </div>

                                        <!-- Re-type Password -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-repassword">
                                                Re-type Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input 
                                                    type="password" 
                                                    class="form-control passwordField" 
                                                    id="user-repassword" 
                                                    name="user-repassword" 
                                                    placeholder="Re-type new password" 
                                                    required
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary" 
                                                    type="button" 
                                                    id="toggleRePassword"
                                                >
                                                    <i class="mdi mdi-eye-outline" id="toggleReIcon"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">
                                                <i class="mdi mdi-information-outline me-1"></i>
                                                Must match the password above
                                            </small>
                                        </div>

                                        <!-- Password Strength Indicator (Optional) -->
                                        <div class="mb-4">
                                            <label class="form-label">Password Strength:</label>
                                            <div class="progress" style="height: 5px;">
                                                <div 
                                                    class="progress-bar" 
                                                    id="passwordStrength" 
                                                    role="progressbar" 
                                                    style="width: 0%"
                                                    aria-valuenow="0" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100"
                                                ></div>
                                            </div>
                                            <small class="text-muted" id="strengthText">Enter a password to see strength</small>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="mb-3 row">
                                            <div class="col-12">
                                                <a href="<?=DNADMIN?>/company/users/list" class="btn btn-secondary waves-effect">
                                                    <i class="mdi mdi-cancel me-1"></i> Cancel
                                                </a>
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                    <i class="mdi mdi-lock-reset me-1"></i> Update Password
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tips Card -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="mdi mdi-shield-lock-outline me-2"></i>Security Tips
                </h5>
                <ul class="mb-0">
                    <li class="mb-2">Never share your password with anyone</li>
                    <li class="mb-2">Use a unique password that you don't use elsewhere</li>
                    <li class="mb-2">Consider using a password manager</li>
                    <li class="mb-2">Change your password regularly</li>
                    <li>Avoid using personal information in your password</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<script>
$(document).ready(function(){
    // Toggle password visibility for first field
    $('#togglePassword').click(function(){
        const passwordField = $('#user-password');
        const icon = $('#toggleIcon');
        
        if(passwordField.attr("type") === 'password'){
            passwordField.attr("type", "text");
            icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
        } else {
            passwordField.attr("type", "password");
            icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
        }
    });

    // Toggle password visibility for second field
    $('#toggleRePassword').click(function(){
        const passwordField = $('#user-repassword');
        const icon = $('#toggleReIcon');
        
        if(passwordField.attr("type") === 'password'){
            passwordField.attr("type", "text");
            icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
        } else {
            passwordField.attr("type", "password");
            icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
        }
    });

    // Legacy support for old show/hide toggle
    $('#pwdvisibility').click(function(){
        if($('.passwordField').attr("type") == 'password'){
            $('.passwordField').attr("type", "text");
            $('#pwdvisibility').html("Hide password");
        } else {
            $('.passwordField').attr("type", "password");
            $('#pwdvisibility').html("Show password");
        }
    });

    // Password strength checker
    $('#user-password').on('keyup', function(){
        const password = $(this).val();
        let strength = 0;
        
        if(password.length >= 8) strength += 20;
        if(password.length >= 12) strength += 10;
        if(/[a-z]/.test(password)) strength += 20;
        if(/[A-Z]/.test(password)) strength += 20;
        if(/[0-9]/.test(password)) strength += 15;
        if(/[^a-zA-Z0-9]/.test(password)) strength += 15;
        
        const progressBar = $('#passwordStrength');
        const strengthText = $('#strengthText');
        
        progressBar.css('width', strength + '%');
        progressBar.attr('aria-valuenow', strength);
        
        // Update color and text based on strength
        progressBar.removeClass('bg-danger bg-warning bg-info bg-success');
        
        if(strength < 30) {
            progressBar.addClass('bg-danger');
            strengthText.text('Weak password').css('color', '#f46a6a');
        } else if(strength < 50) {
            progressBar.addClass('bg-warning');
            strengthText.text('Fair password').css('color', '#f1b44c');
        } else if(strength < 80) {
            progressBar.addClass('bg-info');
            strengthText.text('Good password').css('color', '#50a5f1');
        } else {
            progressBar.addClass('bg-success');
            strengthText.text('Strong password').css('color', '#34c38f');
        }
    });

    // Password match checker
    $('#user-repassword').on('keyup', function(){
        const password = $('#user-password').val();
        const rePassword = $(this).val();
        
        if(rePassword.length > 0) {
            if(password === rePassword) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });
});
</script>

<style>
.is-valid {
    border-color: #34c38f !important;
}

.is-invalid {
    border-color: #f46a6a !important;
}

.input-group .btn-outline-secondary:hover {
    background-color: #f8f9fa;
}
</style>