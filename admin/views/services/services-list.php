<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">All Services</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <div class="dropdown">
                    <a class="btn btn-primary " aria-expanded="false" href="<?=DNADMIN?>/app/services/new">
                        <i class="mdi mdi-plus me-2"></i> Create service
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
                <h4 class="card-title mb-4">Services List</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th scope="col">#NO</th>
                                <th scope="col">Service Name</th>
                                <th scope="col">Default Amount UGX</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $serviceClass = new Service();
                            if($serviceClass->getAll()){
                                $services = $serviceClass->data();
                                $count = 1;
                                foreach($services as $service){
                                    $status_badge = ($service->status == 'active') ? 'bg-success' : 'bg-danger';
                                    $status_text = ($service->status == 'active') ? 'Active' : 'Inactive';
                                    $created_date = date('d-m-Y', strtotime($service->created_at));
                            ?>
                            <tr>
                                <th scope="row"><?= $count++; ?></th>
                                <td><?= htmlspecialchars($service->service_name); ?></td>
                                <td><?= number_format($service->default_amount, 0); ?></td>
                                <td><?= $created_date; ?></td>
                                <td><span class="badge <?= $status_badge; ?>"><?= $status_text; ?></span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle three-dots" 
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                            <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);" 
                                               onclick="openEditModal(<?= $service->id; ?>, '<?= htmlspecialchars($service->service_name, ENT_QUOTES); ?>', <?= $service->default_amount; ?>)">
                                                <i class="mdi mdi-pencil me-1"></i> Edit
                                            </a>
                                            
                                            <?php if($service->status == 'active'){ ?>
                                            <a class="dropdown-item" href="javascript:void(0);" 
                                               onclick="changeServiceStatus(<?= $service->id; ?>, 'deactivate')">
                                                <i class="mdi mdi-close-circle me-1"></i> Deactivate
                                            </a>
                                            <?php } else { ?>
                                            <a class="dropdown-item" href="javascript:void(0);" 
                                               onclick="changeServiceStatus(<?= $service->id; ?>, 'activate')">
                                                <i class="mdi mdi-check-circle me-1"></i> Activate
                                            </a>
                                            <?php } ?>
                                            
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);" 
                                               onclick="deleteService(<?= $service->id; ?>, '<?= htmlspecialchars($service->service_name, ENT_QUOTES); ?>')">
                                                <i class="mdi mdi-delete me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">No services found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="request" value="service-edit">
                <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
                <input type="hidden" name="register-submited" value="1">
                <input type="hidden" name="register-event_token" value="<?= md5(uniqid(rand(), true)); ?>">
                <input type="hidden" name="register-service_id" id="edit_service_id">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="edit_service_name">Service Name</label>
                        <input type="text" class="form-control" id="edit_service_name" 
                               name="register-service_name" placeholder="Enter service name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="edit_default_amount">Default Amount (UGX) <span class="text-muted">(Optional)</span></label>
                        <input type="number" class="form-control" id="edit_default_amount" 
                               name="register-default_amount" placeholder="Enter amount in UGX (optional)">
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hidden forms for status changes -->
<form method="POST" action="" id="statusForm" style="display: none;">
    <input type="hidden" name="request" value="service-status">
    <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
    <input type="hidden" name="service-id" id="status_service_id">
    <input type="hidden" name="activate" id="status_activate" value="0">
    <input type="hidden" name="deactivate" id="status_deactivate" value="0">
</form>

<form method="POST" action="" id="deleteForm" style="display: none;">
    <input type="hidden" name="request" value="service-delete">
    <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">
    <input type="hidden" name="service-id" id="delete_service_id">
</form>

<script>
// Open edit modal with service data
function openEditModal(serviceId, serviceName, defaultAmount) {
    document.getElementById('edit_service_id').value = serviceId;
    document.getElementById('edit_service_name').value = serviceName;
    document.getElementById('edit_default_amount').value = defaultAmount;
    
    var modal = new bootstrap.Modal(document.getElementById('editServiceModal'));
    modal.show();
}

// Change service status
function changeServiceStatus(serviceId, action) {
    var actionText = (action === 'activate') ? 'activate' : 'deactivate';
    
    if(confirm('Are you sure you want to ' + actionText + ' this service?')) {
        document.getElementById('status_service_id').value = serviceId;
        
        if(action === 'activate') {
            document.getElementById('status_activate').value = '1';
            document.getElementById('status_deactivate').value = '0';
        } else {
            document.getElementById('status_activate').value = '0';
            document.getElementById('status_deactivate').value = '1';
        }
        
        document.getElementById('statusForm').submit();
    }
}

// Delete service
function deleteService(serviceId, serviceName) {
    if(confirm('Are you sure you want to delete "' + serviceName + '"? This action cannot be undone.')) {
        document.getElementById('delete_service_id').value = serviceId;
        document.getElementById('deleteForm').submit();
    }
}
</script>