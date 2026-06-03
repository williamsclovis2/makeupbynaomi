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

// Get filters
$filters = array();
if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
    $filters['from_date'] = $_GET['from_date'];
}
if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
    $filters['to_date'] = $_GET['to_date'];
}
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $filters['keyword'] = $_GET['keyword'];
}

// Get all bookings
$bookings = BookingController::getAllBookings($filters);

// Get all workers for dropdowns
$workers = BookingController::getAllWorkers();

// Get overlapped booking IDs
$bookingClass = new Booking();
$overlapped_booking_ids = $bookingClass->getOverlappedBookings();

// Fetch active services for edit modal
$serviceClass = new Service();
$serviceClass->getActiveServices();
$services = $serviceClass->data();
?>

<style>
.booking-overlap-row {
    background-color: #ffcccc !important;
}
.booking-overlap-row td,
.booking-overlap-row th {
    background-color: #ffcccc !important;
}
.table-hover .booking-overlap-row:hover td,
.table-hover .booking-overlap-row:hover th {
    background-color: #ff9999 !important;
}
#table-head th {
    white-space: nowrap;
}
#edit_service_type {
    height: auto !important;
    min-height: 150px;
}
#edit_service_type option {
    padding: 8px;
}
#edit_service_type option:checked {
    background-color: #4a90e2;
    color: white;
}
</style>

<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Bookings List</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-primary" href="<?=DNADMIN?>/app/booking/new">
                    <i class="mdi mdi-plus me-2"></i> Add Booking
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Bookings List</h4>
                
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-information me-2"></i>
                    <strong>Legend:</strong> 
                    <span class="badge" style="background-color: #ffcccc; color: #000;">Red Background</span> = Overlapped booking (same date & time)
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                <!-- Filter Form -->
                <div class="col-xs-12 col-sm-12 mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk" value="booking">
                        <input type="hidden" name="branch" value="list">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="<?= @$_GET['from_date'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="<?= @$_GET['to_date'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">Search Name/Email/Phone</label>
                                    <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?= @$_GET['keyword'] ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="ti-search"></i> Search
                                    </button>
                                    <a href="<?=DNADMIN?>/app/booking/list" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if(count($bookings) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th>#</th>
                                <th>Day & Date</th>
                                <th>Time</th>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Service(s)</th>
                                <th>Worker</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Entry</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 1;
                            foreach($bookings as $booking): 
                                $row_class = in_array($booking->id, $overlapped_booking_ids) ? 'booking-overlap-row' : '';
                                
                                // --- STATUS BADGE ---
                                $status_badge = '';
                                switch($booking->status) {
                                    case 'pending':
                                        $status_badge = '<span class="badge bg-warning text-dark">Pending</span>';
                                        break;
                                    case 'booked':
                                        $status_badge = '<span class="badge bg-success">Booked</span>';
                                        break;
                                    case 'cancelled':
                                        $status_badge = '<span class="badge bg-danger">Cancelled</span>';
                                        break;
                                    default:
                                        $status_badge = '<span class="badge bg-secondary">' . ucfirst($booking->status) . '</span>';
                                }
                                
                                // Get day name from date
                                $dayName = date('l', strtotime($booking->booking_date));
                                $dateFormatted = date('d-m-Y', strtotime($booking->booking_date));
                                
                                $worker_display = $booking->preferred_worker_name ?? 'Any';
                            ?>
                            <tr class="<?= $row_class ?>">
                                <th><?= $counter ?></th>
                                <td>
                                    <strong><?= $dayName ?></strong><br>
                                    <small><?= $dateFormatted ?></small>
                                </td>
                                <td><?= date('h:i A', strtotime($booking->booking_time)) ?></td>
                                <td><?= htmlspecialchars($booking->client_name) ?></td>
                                <td><?= htmlspecialchars($booking->client_phone) ?></td>
                                <td><?= htmlspecialchars($booking->service_type) ?></td>
                                <td><?= htmlspecialchars($worker_display) ?></td>
                                <td><?= !empty($booking->expected_price) ? number_format($booking->expected_price, 0) . ' UGX' : '-' ?></td>
                                <td><?= $status_badge ?></td>
                                <td>
                                    <?php if(!empty($booking->entry_id)): ?>
                                        <a href="<?=DNADMIN?>/app/entries/list" class="badge bg-success">#<?= $booking->entry_id ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                            Actions <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">

                                            <?php if($booking->status === 'pending'): ?>
                                                <?php if(!empty($booking->preferred_worker_id) && empty($booking->entry_id)): ?>
                                                <!-- Make Entry: only pending + worker assigned + no entry yet -->
                                                <form method="POST" action="" style="display: inline;" onsubmit="return confirm('Create entry for this booking?');">
                                                    <input type="hidden" name="request" value="booking-create-entry">
                                                    <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="mdi mdi-file-document text-success"></i> Make Entry
                                                    </button>
                                                </form>
                                                <?php endif; ?>

                                                <!-- Edit: only pending -->
                                                <a class="dropdown-item" href="#" onclick="openEditModal(<?= $booking->id ?>)">
                                                    <i class="mdi mdi-pencil text-info"></i> Edit
                                                </a>

                                                <div class="dropdown-divider"></div>

                                                <!-- Cancel: only pending -->
                                                <form method="POST" action="" style="display: inline;" onsubmit="return confirm('Cancel this booking?');">
                                                    <input type="hidden" name="request" value="booking-cancel">
                                                    <input type="hidden" name="booking_id" value="<?= $booking->id ?>">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="mdi mdi-close-circle"></i> Cancel
                                                    </button>
                                                </form>

                                            <?php elseif($booking->status === 'booked'): ?>
                                                <!-- Booked: view entry link only -->
                                                <?php if(!empty($booking->entry_id)): ?>
                                                <a class="dropdown-item" href="<?=DNADMIN?>/app/entries/list">
                                                    <i class="mdi mdi-eye text-success"></i> View Entry #<?= $booking->entry_id ?>
                                                </a>
                                                <?php else: ?>
                                                <span class="dropdown-item text-muted">No actions available</span>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <!-- Cancelled or other statuses -->
                                                <span class="dropdown-item text-muted">No actions available</span>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            $counter++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> No bookings found. <a href="<?=DNADMIN?>/app/booking/new">Create your first booking</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- EDIT BOOKING MODAL -->
<div class="modal fade" id="editBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="editBookingForm">
                <input type="hidden" name="request" value="booking-update">
                <input type="hidden" name="booking_id" id="edit_booking_id">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="client_name" id="edit_client_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="client_phone" id="edit_client_phone" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="client_email" id="edit_client_email">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Service(s) <span class="text-danger">*</span></label>
                            <select class="form-select" name="service_type[]" id="edit_service_type" multiple required size="6">
                                <?php 
                                if($services && is_array($services)){
                                    foreach($services as $service){
                                ?>
                                <option value="<?= htmlspecialchars($service->service_name); ?>">
                                    <?= htmlspecialchars($service->service_name); ?>
                                </option>
                                <?php 
                                    }
                                }
                                ?>
                                <option value="other">Other (Specify)</option>
                            </select>
                            <small class="text-muted">Hold Ctrl / Cmd for multiple</small>
                            
                            <div id="edit_other_service_container" style="display: none;" class="mt-2">
                                <label class="form-label">Custom Service <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_other_service_name" name="other_service_name" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Worker</label>
                            <select class="form-select" name="preferred_worker" id="edit_preferred_worker">
                                <option value="">Any Worker</option>
                                <?php foreach($workers as $worker): ?>
                                    <option value="<?= $worker->ID ?>"><?= htmlspecialchars($worker->firstname . ' ' . $worker->lastname) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="booking_date" id="edit_booking_date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Time <span class="text-danger">*</span></label>
                            <select class="form-select" name="booking_time" id="edit_booking_time" required>
                                <option value="">-- select --</option>
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price (UGX)</label>
                            <input type="number" class="form-control" name="price" id="edit_price">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" id="edit_notes" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var bookingsData = <?= json_encode($bookings) ?>;
var servicesMap = <?php 
    $map = [];
    if($services && is_array($services)){
        foreach($services as $s){
            $map[$s->service_name] = true;
        }
    }
    echo json_encode($map);
?>;

function openEditModal(id) {
    var booking = bookingsData.find(b => b.id == id);
    if (!booking) return;
    
    document.getElementById('edit_booking_id').value = booking.id;
    document.getElementById('edit_client_name').value = booking.client_name;
    document.getElementById('edit_client_phone').value = booking.client_phone;
    document.getElementById('edit_client_email').value = booking.client_email || '';
    
    var services = booking.service_type.split(',').map(s => s.trim());
    var select = document.getElementById('edit_service_type');
    var hasCustom = false;
    var customName = '';
    
    Array.from(select.options).forEach(opt => opt.selected = false);
    
    services.forEach(function(svc) {
        if (servicesMap[svc]) {
            Array.from(select.options).forEach(opt => {
                if (opt.value === svc) opt.selected = true;
            });
        } else if (svc) {
            hasCustom = true;
            customName = svc;
        }
    });
    
    if (hasCustom) {
        Array.from(select.options).forEach(opt => {
            if (opt.value === 'other') opt.selected = true;
        });
        document.getElementById('edit_other_service_container').style.display = 'block';
        document.getElementById('edit_other_service_name').value = customName;
        document.getElementById('edit_other_service_name').disabled = false;
        document.getElementById('edit_other_service_name').required = true;
    }
    
    document.getElementById('edit_preferred_worker').value = booking.preferred_worker_id || '';
    document.getElementById('edit_booking_date').value = booking.booking_date;
    document.getElementById('edit_booking_time').value = booking.booking_time;
    document.getElementById('edit_price').value = booking.expected_price || '';
    document.getElementById('edit_notes').value = booking.notes || '';
    
    new bootstrap.Modal(document.getElementById('editBookingModal')).show();
}

document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('edit_service_type');
    const container = document.getElementById('edit_other_service_container');
    const input = document.getElementById('edit_other_service_name');
    
    if (select) {
        select.addEventListener('change', function() {
            const hasOther = Array.from(this.selectedOptions).some(opt => opt.value === 'other');
            if (hasOther) {
                container.style.display = 'block';
                input.disabled = false;
                input.required = true;
            } else {
                container.style.display = 'none';
                input.disabled = true;
                input.required = false;
                input.value = '';
            }
        });
    }
});
</script>