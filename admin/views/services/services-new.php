<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Create Services</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <div class="dropdown">
                    <a class="btn btn-primary " aria-expanded="false" href="<?=DNADMIN?>/app/services/list">
                        <i class="ti-view-grid me-2"></i> Services list
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<?php Functions::flashMsg(); ?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">New Service</h4>
                <div class="card overflow-hidden">
                    <div class="card-body " style="padding: unset !important;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="p-3 form-card">
                                    <form class="mt-2" method="POST" action="">
                                        <input type="hidden" name="request" value="service-new">
                                        <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
                                        <input type="hidden" name="register-submited" value="1">
                                        <input type="hidden" name="register-event_token" value="<?= md5(uniqid(rand(), true)); ?>">
                                        
                                        <div class="mt-2 mb-0 row">
                                            <div class="col-12 mb-2">
                                                <p class="mb-0" style="color: red;">* Service name is required</p>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label" for="service_name">Service Name</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   id="service_name" 
                                                   name="register-service_name" 
                                                   placeholder="Enter service name (e.g., Gel Nails, Manicure)" 
                                                   required>
                                        </div>
    
                                        <div class="mb-4">
                                            <label class="form-label" for="default_amount">Default Amount (UGX) <span class="text-muted">(Optional)</span></label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="default_amount" 
                                                   name="register-default_amount" 
                                                   placeholder="Enter amount in UGX (optional)" 
                                                   min="0"
                                                   step="1000">
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-12 text-end">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                                    <i class="mdi mdi-content-save me-1"></i> Submit
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
</div>
<!-- end row -->