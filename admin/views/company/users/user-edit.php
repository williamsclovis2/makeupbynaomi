<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Edit User</h6>
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
?>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit User Information</h4>
                <div class="card overflow-hidden">
                    <div class="card-body" style="padding: unset !important;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="p-3 form-card">
                                    <form method="POST" action="" class="mt-2">
                                        <input type="hidden" name="webToken" value="56">
                                        <input type="hidden" name="request" value="user-update">
                                        <input type="hidden" name="id" value="<?php echo $user_data->ID; ?>">
                                        <input type="hidden" name="token" value="true">
                                        <input type="hidden" name="task" value="user-update">

                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <p class="text-danger mb-0">* All fields are mandatory</p>
                                            </div>
                                        </div>

                                        <!-- First Name -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-firstname">First Name</label>
                                            <span class="text-danger small d-block">
                                                <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['firstname'][0]; } ?>
                                            </span>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="user-firstname" 
                                                name="user-firstname" 
                                                placeholder="First name" 
                                                value="<?= $user_data->firstname ?>" 
                                                required
                                            >
                                        </div>

                                        <!-- Last Name -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-lastname">Last Name</label>
                                            <span class="text-danger small d-block">
                                                <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['lastname'][0]; } ?>
                                            </span>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="user-lastname" 
                                                name="user-lastname" 
                                                placeholder="Last name" 
                                                value="<?= $user_data->lastname ?>" 
                                                required
                                            >
                                        </div>

                                        <!-- Telephone -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-telephone">Telephone</label>
                                            <span class="text-danger small d-block">
                                                <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['telephone'][0]; } ?>
                                            </span>
                                            <input 
                                                type="tel" 
                                                class="form-control" 
                                                id="user-telephone" 
                                                name="user-telephone" 
                                                placeholder="Telephone number" 
                                                value="<?= $user_data->phone ?>" 
                                                required
                                            >
                                        </div>

                                        <!-- Permission -->
                                        <div class="mb-4">
                                            <label class="form-label" for="user-groups">Permission</label>
                                            <span class="text-danger small d-block">
                                                <?php if($form->ERRORS){ echo @$form->ERRORS_SCRIPT['groups'][0]; } ?>
                                            </span>
                                            <select class="form-select" id="user-groups" name="user-groups" required>
                                                <?php if($session_user_data->groups == "Admin"): ?>
                                                    <option value="<?php echo $user_data->groups; ?>" selected>
                                                        <?php echo $user_data->groups; ?>
                                                    </option>
                                                <?php endif; ?>

                                                <?php if($session_user_data->groups == "ContentMan" || $session_user_data->groups == "Admin"): ?>
                                                    <option value="ContentMan">Content Manager</option>
                                                <?php endif; ?>

                                                <?php if($session_user_data->groups == "Admin"): ?>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Worker">Worker</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="mb-3 row">
                                            <div class="col-12">
                                                <a href="<?=DNADMIN?>/company/users/list" class="btn btn-secondary waves-effect">
                                                    <i class="mdi mdi-cancel me-1"></i> Cancel
                                                </a>
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                    <i class="mdi mdi-content-save me-1"></i> Update User
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
    </div>

    <!-- Optional: User Info Card (if you want to show additional info) -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">User Details</h4>
                
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 40%;">User ID:</th>
                                <td><?= $user_data->ID ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Full Name:</th>
                                <td><?= $user_data->firstname . ' ' . $user_data->lastname ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Email:</th>
                                <td><?= $user_data->email ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Role:</th>
                                <td>
                                    <?php 
                                    $role_badge = '';
                                    switch($user_data->groups) {
                                        case 'Admin':
                                            $role_badge = '<span class="badge bg-danger">Admin</span>';
                                            break;
                                        case 'Worker':
                                            $role_badge = '<span class="badge bg-primary">Worker</span>';
                                            break;
                                        case 'ContentMan':
                                            $role_badge = '<span class="badge bg-info">Content Manager</span>';
                                            break;
                                        default:
                                            $role_badge = '<span class="badge bg-secondary">' . $user_data->groups . '</span>';
                                    }
                                    echo $role_badge;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Status:</th>
                                <td>
                                    <?php if($user_data->state == 'activated' || $user_data->state == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Created:</th>
                                <td><?= isset($user_data->created_date) ? date('d M Y', strtotime($user_data->created_date)) : 'N/A' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <h5 class="font-size-14 mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="<?=DNADMIN?>/company/users/reset-password?id=<?= $user_data->ID ?>" class="btn btn-outline-warning btn-sm">
                            <i class="mdi mdi-lock-reset me-1"></i> Reset Password
                        </a>
                        <?php if($user_data->state == 'activated' || $user_data->state == 'active'): ?>
                            <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Deactivate this user?')">
                                <i class="mdi mdi-account-off me-1"></i> Deactivate User
                            </button>
                        <?php else: ?>
                            <button class="btn btn-outline-success btn-sm">
                                <i class="mdi mdi-account-check me-1"></i> Activate User
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<script>
$(document).ready(function(){
    $('#pwdvisibility').click(function(){
        if($('.passwordField').attr("type")=='password'){
            $('.passwordField').attr("type","text");
            $('#pwdvisibility').html("Hide password");
        }else{
            $('.passwordField').attr("type","password");
            $('#pwdvisibility').html("Show password");
        }
    });
});
</script>