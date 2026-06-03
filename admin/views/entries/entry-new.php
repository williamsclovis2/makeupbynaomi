<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">New Entry</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-secondary" href="<?=DNADMIN?>/app/entries/list">
                    <i class="mdi mdi-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<?php
// Use global session variables instead of creating new objects
global $session_user_data;
global $session_user_ID;

// Fallback if globals not set
if(!isset($session_user_data)) {
    echo "<div class='alert alert-danger'>Session error. Please <a href='".DNADMIN."/logout'>logout</a> and login again.</div>";
    die();
}

$logged_user_id = $session_user_ID;
$logged_user_data = $session_user_data;
$user_type = $logged_user_data->groups;

// Get all workers for dropdown using direct query
$db = DB::getInstance();

// First, let's check what the actual state value is
$state_check = $db->query("SELECT DISTINCT state FROM app_users LIMIT 5");
$states = $state_check->results();

// Try both 'active' and 'Activated' since we're not sure which one is used
$workers_query = $db->query("SELECT ID, firstname, lastname, groups, state FROM app_users WHERE groups IN ('Worker','Admin','Sub-Admin') AND state IN ('active','Activated') ORDER BY firstname ASC");
$all_workers = $workers_query->results();
?>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">New Service Entry</h4>
                
                <?php if(count($all_workers) == 0): ?>
                    <div class="alert alert-warning">
                        <strong>No workers found!</strong> Please add workers first before creating entries.
                        <br><small>Current state values in database: 
                        <?php foreach($states as $s) { echo "'" . $s->state . "' "; } ?>
                        </small>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <input type="hidden" name="request" value="entry-new">
                    <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
                    <input type="hidden" name="register-submited" value="1">
                    <input type="hidden" name="register-event_token" value="<?= md5(uniqid(rand(), true)); ?>">
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p class="text-danger mb-0">* All fields are mandatory except notes</p>
                        </div>
                    </div>
                    
                    <!-- Worker Selection -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <?php if($user_type == 'Admin' || $user_type == 'Sub-Admin'): ?>
                                <label class="form-label" for="user_id">Select Worker <span class="text-danger">*</span></label>
                                <select class="form-select" id="user_id" name="register-user_id" required>
                                    <option value="">[ -- select worker -- ]</option>
                                    <?php foreach($all_workers as $worker): ?>
                                        <option value="<?= $worker->ID ?>"><?= $worker->firstname . ' ' . $worker->lastname ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <input type="hidden" name="register-user_id" value="<?= $logged_user_id ?>">
                                <label class="form-label">Worker Name</label>
                                <input type="text" class="form-control" value="<?= $logged_user_data->firstname . ' ' . $logged_user_data->lastname ?>" readonly style="background-color: #e9ecef;">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Service Type and Amount -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?php include 'views'._.'includes/services'.PL;?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="amount">Amount Charged (UGX) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="register-amount" placeholder="Enter total amount" required>

                            <!-- payment method -->
                            <label class="form-label mt-3" for="amount">Payment method <span class="text-danger">*</span></label>
                            <select class="form-select" name="payment_method" id="paymentMethod" required>
                                <option value="">Select payment method</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="mobile_money">Mobile Money</option>
                            </select>
                        </div>
                    </div>

                    <!-- Collaboration checkbox -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="collaboration_check" name="register-collaboration_check" value="1">
                                <label class="form-check-label" for="collaboration_check">
                                    Worked with another worker?
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Collaborators Select -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="coworkers">Select Coworker(s)</label>
                            <select class="form-select" id="coworkers" name="register-coworkers[]" multiple disabled>
                                <?php foreach($all_workers as $worker): ?>
                                    <option value="<?= $worker->ID ?>"><?= $worker->firstname . ' ' . $worker->lastname ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Hold Ctrl / Cmd to select multiple workers</small>
                        </div>
                    </div>

                    <!-- Collaboration Amounts -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Collaboration Amounts (UGX)</label>
                            <div id="collab_amount_inputs">
                                <?php foreach($all_workers as $worker): ?>
                                <div class="mb-2 collab-amount-row" data-user-id="<?= $worker->ID ?>" style="display:none;">
                                    <label class="form-label"><?= $worker->firstname . ' ' . $worker->lastname ?> Amount</label>
                                    <input type="number" step="0.01" class="form-control collab_input" name="register-collab_amounts[<?= $worker->ID ?>]" placeholder="Enter amount for <?= $worker->firstname ?>" disabled>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted">Enter amount each coworker will receive</small>
                        </div>
                    </div>

                    <!-- Worker Final Share -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="user_final_amount">Your Share (UGX)</label>
                            <input type="number" step="0.01" class="form-control" id="user_final_amount" name="register-user_final_amount" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="notes">Notes (optional)</label>
                            <textarea class="form-control" id="notes" name="register-notes" rows="3" placeholder="Any additional notes"></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                <i class="mdi mdi-content-save me-1"></i> Save Service
                            </button>
                            <a href="<?=DNADMIN?>/app/entries/list" class="btn btn-secondary waves-effect">
                                <i class="mdi mdi-cancel me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

