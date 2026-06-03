<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">New Booking</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-secondary" href="<?=DNADMIN?>/app/booking/list">
                    <i class="mdi mdi-arrow-left me-2"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<?php
// Get all workers for dropdown
$db = DB::getInstance();
$workers_query = $db->query("SELECT ID, firstname, lastname FROM app_users WHERE (groups = 'Worker' OR groups = 'Admin') AND (state = 'active' OR state = 'Activated') ORDER BY firstname ASC");
$all_workers = $workers_query->results();

// Fetch active services
$serviceClass = new Service();
$serviceClass->getActiveServices();
$services = $serviceClass->data();
?>

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Create New Booking</h4>
                
                <form method="POST" action="">
                    <input type="hidden" name="request" value="booking-new">
                    <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
                    <input type="hidden" name="register-submited" value="1">
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p class="text-danger mb-0">* All fields are mandatory except email, expected price and notes</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="client_name">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="client_name" name="register-client_name" placeholder="Enter client's full name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="client_phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="client_phone" name="register-client_phone" placeholder="Enter phone number" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="client_email">Email Address</label>
                            <input type="email" class="form-control" id="client_email" name="register-client_email" placeholder="Enter email address (optional)">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="service_type">Service Type(s) <span class="text-danger">*</span></label>
                            <select class="form-select" id="service_type" name="register-service_type[]" multiple required size="6">
                                <?php 
                                if($services && is_array($services)){
                                    foreach($services as $service){
                                        $display_text = htmlspecialchars($service->service_name);
                                ?>
                                <option value="<?= htmlspecialchars($service->service_name); ?>">
                                    <?= $display_text; ?>
                                </option>
                                <?php 
                                    }
                                }
                                ?>
                                <option value="other">Other (Specify)</option>
                            </select>
                            <small class="text-muted">Hold Ctrl / Cmd to select multiple services</small>
                            
                            <div id="other_service_container" style="display: none;" class="mt-2">
                                <label class="form-label" for="other_service_name">Specify Custom Service Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="other_service_name" 
                                       name="register-other_service_name" 
                                       placeholder="Enter custom service name"
                                       disabled>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="preferred_worker">Preferred Worker</label>
                            <select class="form-select" id="preferred_worker" name="register-preferred_worker">
                                <option value="">Any Available Worker</option>
                                <?php foreach($all_workers as $worker): ?>
                                    <option value="<?= $worker->ID ?>">
                                        <?= htmlspecialchars($worker->firstname . ' ' . $worker->lastname) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="expected_price">Expected Price (UGX)</label>
                            <input type="number" class="form-control" id="expected_price" name="register-expected_price" placeholder="Optional">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="booking_date">Booking Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="booking_date" name="register-booking_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="booking_time">Booking Time <span class="text-danger">*</span></label>
                            <select class="form-select" id="booking_time" name="register-booking_time" required>
                                <option value="">[ -- select time -- ]</option>
                                <option value="09:00">09:00 AM</option>
                                <option value="09:30">09:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="12:30">12:30 PM</option>
                                <option value="13:00">01:00 PM</option>
                                <option value="13:30">01:30 PM</option>
                                <option value="14:00">02:00 PM</option>
                                <option value="14:30">02:30 PM</option>
                                <option value="15:00">03:00 PM</option>
                                <option value="15:30">03:30 PM</option>
                                <option value="16:00">04:00 PM</option>
                                <option value="16:30">04:30 PM</option>
                                <option value="17:00">05:00 PM</option>
                                <option value="17:30">05:30 PM</option>
                                <option value="18:00">06:00 PM</option>
                            </select>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="register-notes" rows="3" placeholder="Any special requests or notes (optional)"></textarea>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                <i class="mdi mdi-content-save me-1"></i> Create Booking
                            </button>
                            <a href="<?=DNADMIN?>/app/booking/list" class="btn btn-secondary waves-effect">
                                <i class="mdi mdi-cancel me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_type');
    const otherContainer = document.getElementById('other_service_container');
    const otherInput = document.getElementById('other_service_name');
    
    if (serviceSelect) {
        serviceSelect.addEventListener('change', function() {
            const selectedOptions = Array.from(this.selectedOptions);
            const hasOther = selectedOptions.some(opt => opt.value === 'other');
            
            if (hasOther) {
                otherContainer.style.display = 'block';
                otherInput.disabled = false;
                otherInput.required = true;
            } else {
                otherContainer.style.display = 'none';
                otherInput.disabled = true;
                otherInput.required = false;
                otherInput.value = '';
            }
        });
    }
});
</script>

<style>
#service_type {
    height: auto !important;
    min-height: 150px;
}

#service_type option {
    padding: 8px;
}

#service_type option:checked {
    background-color: #4a90e2;
    color: white;
}
</style>