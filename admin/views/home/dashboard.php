
<?php
// Get dashboard data
$stats = DashboardController::getDashboardStats();
$todayEntries = DashboardController::getTodayLiveEntries(10);
$workerSummary = DashboardController::getWorkerEarningsSummary();
$todayEntries = DashboardController::getLast24HoursEntries(50); // Get last 50 entries from 24 hours



?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php
            // Display success messages
            if (Session::exists('success')) {
                echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i><strong>Success!</strong> ' . Session::flash('success') . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }

            // Display error messages
            // Display error messages
            if (Session::exists('errors')) {
                $errors = Session::flash('errors');
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        if (!empty($error) && $error !== 'ERRORS_FOUND') {
                            echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <i class="mdi mdi-alert-circle me-2"></i><strong>Error!</strong> ' . htmlspecialchars($error) . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        }
                    }
                } else if (!empty($errors)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="mdi mdi-alert-circle me-2"></i><strong>Error!</strong> ' . htmlspecialchars($errors) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Dashboard</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <?php if($session_user_data->groups !== 'Worker'): ?>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <div class="dropdown">
                    <a href="<?=DNADMIN?>/app/entries/new" class="btn btn-primary">
                        <i class="mdi mdi-plus me-2"></i> Create Entry
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- end page title -->
<?php if($session_user_data->groups !== 'Worker'): ?>
<div class="row">
    
     <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/01.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Today's Entry</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['today_entries']) ?> <i
                            class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/list" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View entries</p>
                </div>
            </div>
        </div>
    </div>
    <?php if($session_user_data->groups !== 'Sub-Admin'): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/01.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">All Entries</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['all_entries']) ?> <i
                            class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/list" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View all</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/01.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Pending Entries</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['pending_entries']) ?> <i
                            class="mdi mdi-arrow-up text-warning ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/list" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View pending</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/02.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Total income today</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['today_income'], 0) ?> <i
                            class="mdi mdi-chart-line text-success ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/matrix" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View matrix</p>
                </div>
            </div>
        </div>
    </div>
     <?php if($session_user_data->groups !== 'Sub-Admin'): ?>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/03.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Monthly total income</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['monthly_income'], 0) ?> <i
                            class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/matrix" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View details</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/04.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Yearly total income</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['yearly_income'], 0) ?> <i
                            class="mdi mdi-arrow-up text-success ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="<?=DNADMIN?>/app/entries/matrix" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View yearly</p>
                </div>
            </div>
        </div>
    </div>
     <?php endif; ?>
    
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body dash-details">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-2">
                        <img src="assets/images/services-icon/04.png" alt="">
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Available Bookings</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($stats['available_bookings']) ?> <i
                            class="mdi mdi-calendar text-info ms-2"></i></h4>
                    
                </div>
                <div class="pt-2">
                    <div class="float-end">
                        <a href="#" class="text-white-50"><i class="mdi mdi-arrow-right h5 text-white-50"></i></a>
                    </div>

                    <p class="text-white-50 mb-0 mt-1">View bookings</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- end row -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Last 24 Hours Activity Feed</h4>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-clock-outline me-2"></i>
                    Showing entries from the last 24 hours. Auto-updates as entries age beyond 24 hours.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                <?php 
                // Filter entries based on role.
                // Workers see entries where they are the PRIMARY worker
                // OR where they appear as a COLLABORATOR on someone else's entry.
                $displayEntries = $todayEntries;
                if($session_user_data->groups === 'Worker') {
                    $displayEntries = array_filter($todayEntries, function($entry) use ($session_user_data) {
                        // Primary worker match
                        $entryArr = (array)$entry;
                        $entryUserId = isset($entryArr['user_id']) ? $entryArr['user_id'] : null;
                        if($entryUserId == $session_user_data->ID) return true;

                        // Also include entries where this worker is a collaborator
                        $collabs = DashboardController::getCollaborators($entry->id);
                        foreach($collabs as $c) {
                            $collabArr = (array)$c;
                            $collabUserId = isset($collabArr['user_id']) ? $collabArr['user_id'] : null;
                            if($collabUserId == $session_user_data->ID) return true;
                        }
                        return false;
                    });
                }
                ?>

                <?php if(count($displayEntries) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th scope="col">#NO</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Service Type</th>
                                <th scope="col">Amount Charged (UGX)</th>
                                <th scope="col">Worker</th>
                                <th scope="col">Collaboration</th>
                                <th scope="col">Collaborated With</th>
                                <th scope="col">My Share (UGX)</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 1;
                            $isWorker = ($session_user_data->groups === 'Worker');

                            foreach($displayEntries as $entry): 
                                $collaborators   = DashboardController::getCollaborators($entry->id);
                                $service_display = ucfirst(str_replace('_', ' ', $entry->service_type));
                                
                                // Is this worker a collaborator (not the primary worker) on this entry?
                                $isCollabOnEntry = false;
                                $myCollabAmount  = null;
                                $entryUserId     = isset($entry->user_id) ? $entry->user_id : null;
                                if($isWorker && $entryUserId != $session_user_data->ID) {
                                    foreach($collaborators as $c) {
                                        $cUserId = isset($c->user_id) ? $c->user_id : (isset($c->ID) ? $c->ID : null);
                                        if($cUserId == $session_user_data->ID) {
                                            $isCollabOnEntry = true;
                                            $myCollabAmount  = $c->amount;
                                            break;
                                        }
                                    }
                                }

                                // Determine "my share" for this worker
                                if($isWorker) {
                                    if($isCollabOnEntry) {
                                        // They are a collaborator — their share is their collab amount
                                        $myShare = $myCollabAmount;
                                    } else {
                                        // They are the primary worker
                                        $myShare = $entry->user_final_amount;
                                    }
                                }

                                // Build "Collaborated With" column
                                // For primary worker  → show all collaborators + their amounts
                                // For a collaborator  → show the primary worker + other collabs, excluding themselves
                                $collabWith = '';
                                if(count($collaborators) > 0) {
                                    if($isWorker && $isCollabOnEntry) {
                                        // Show primary worker first
                                        $collabWith .= '<div class="collab-person">'
                                            . '<span class="collab-role-badge primary">Primary</span> '
                                            . '<strong>' . htmlspecialchars($entry->user_name) . '</strong>'
                                            . ' &nbsp;<span class="collab-amt">' . number_format($entry->user_final_amount, 0) . ' UGX</span>'
                                            . '</div>';
                                        // Show other collaborators (excluding self)
                                        foreach($collaborators as $c) {
                                            $cUserId = isset($c->user_id) ? $c->user_id : (isset($c->ID) ? $c->ID : null);
                                            if($cUserId == $session_user_data->ID) continue;
                                            $collabWith .= '<div class="collab-person">'
                                                . '<span class="collab-role-badge collab">Collab</span> '
                                                . htmlspecialchars($c->user_name)
                                                . ' &nbsp;<span class="collab-amt">' . number_format($c->amount, 0) . ' UGX</span>'
                                                . '</div>';
                                        }
                                    } else {
                                        // Primary worker view (or Admin) — show all collaborators
                                        foreach($collaborators as $c) {
                                            $collabWith .= '<div class="collab-person">'
                                                . '<span class="collab-role-badge collab">Collab</span> '
                                                . htmlspecialchars($c->user_name)
                                                . ' &nbsp;<span class="collab-amt">' . number_format($c->amount, 0) . ' UGX</span>'
                                                . '</div>';
                                        }
                                    }
                                } else {
                                    $collabWith = '<span class="text-muted" style="font-size:12px;">—</span>';
                                }

                                $status_badge = '';
                                switch($entry->status) {
                                    case 'pending':   $status_badge = '<span class="badge bg-warning text-dark">Pending</span>';   break;
                                    case 'completed': $status_badge = '<span class="badge bg-info text-dark">Completed</span>';    break;
                                    case 'paid':      $status_badge = '<span class="badge bg-success">Paid</span>';                break;
                                    case 'cancelled': $status_badge = '<span class="badge bg-danger">Cancelled</span>';            break;
                                    default:          $status_badge = '<span class="badge bg-secondary">Unknown</span>';
                                }
                            ?>
                            <tr <?= ($isWorker && $isCollabOnEntry) ? 'class="collab-entry-row"' : '' ?>>
                                <th scope="row"><?= $counter ?></th>
                                <td><?= date('d-m-Y', strtotime($entry->created_date)) ?></td>
                                <td><?= date('H:i', strtotime($entry->created_time)) ?></td>
                                <td><?= htmlspecialchars($service_display) ?></td>
                                <td><?= number_format($entry->total_amount, 0) ?></td>
                                <td>
                                    <?= htmlspecialchars($entry->user_name) ?>
                                    <?php if($isWorker && $isCollabOnEntry): ?>
                                        <br><span class="badge bg-primary" style="font-size:10px;">You collaborated</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(count($collaborators) > 0): ?>
                                        <span class="badge bg-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $collabWith ?></td>
                                <td>
                                    <?php if($isWorker): ?>
                                        <strong><?= number_format($myShare, 0) ?></strong>
                                    <?php else: ?>
                                        <?= number_format($entry->user_final_amount, 0) ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= $status_badge ?></td>
                            </tr>
                            <?php 
                            $counter++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>

                <style>
                /* Collaboration display styles */
                .collab-person {
                    display: flex; align-items: center; gap: 5px;
                    padding: 2px 0; font-size: 12px; white-space: nowrap;
                }
                .collab-role-badge {
                    font-size: 9px; font-weight: 700; text-transform: uppercase;
                    letter-spacing: .4px; padding: 1px 5px; border-radius: 3px;
                    flex-shrink: 0;
                }
                .collab-role-badge.primary { background: #d4edda; color: #155724; }
                .collab-role-badge.collab  { background: #cce5ff; color: #004085; }
                .collab-amt {
                    color: #2e7d32; font-weight: 600; font-size: 11px;
                }
                /* Highlight rows where the logged-in worker is a collaborator */
                .collab-entry-row { background: #f0f7ff !important; }
                .collab-entry-row:hover { background: #e3f0ff !important; }
                </style>

                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="mdi mdi-information"></i> No entries in the last 24 hours. <a href="<?=DNADMIN?>/app/entries/new">Add an entry</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 3: WORKERS EARNINGS FROM MATRIX -->
<!-- REPLACE YOUR LIQUIDATION TABLE WITH THIS VERSION -->

<!-- SECTION: WORKERS EARNINGS (Current Week Only – Monday to Sunday) -->

<div class="row" id="liquidationsTables">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1">Workers Earnings (Current Week – Paid Entries Only)</h4>
                        <?php
                            // Show the current week range label
                            $weekRange = DashboardController::getCurrentWeekRange();
                        ?>
                        <p class="text-muted mb-0">
                            <i class="mdi mdi-calendar-week me-1"></i>
                            Week: <strong><?= $weekRange['label'] ?></strong> 
                        </p>
                    </div>
                </div>
                
                <?php 
                // Filter worker summary based on role
                $displayWorkers = $workerSummary;
                if($session_user_data->groups === 'Worker') {
                    $displayWorkers = array_filter($workerSummary, function($worker) use ($session_user_data) {
                        return $worker['user_id'] == $session_user_data->ID;
                    });
                }
                ?>

                <?php if(count($displayWorkers) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead class="liquidation-table">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Total Income (Week)</th>
                                <?php if($session_user_data->groups !== 'Worker'): ?>
                                <th scope="col">Company (60%)</th>
                                <?php endif; ?>
                                <th scope="col">Worker (40%)</th>
                                <th scope="col">Paid Out</th>
                                <th scope="col">Pending</th>
                                <th scope="col">Available</th>
                                <?php if($session_user_data->groups !== 'Worker'): ?>
                                <th scope="col">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="liquidation-g">
                            <?php 
                            $counter = 1;
                            foreach($displayWorkers as $worker): 
                            ?>
                            <tr>
                                <th scope="row"><?= $counter ?></th>
                                <td>
                                    <div>
                                        <img src="assets/images/profile.png" alt="" class="avatar-xs rounded-circle me-2">
                                        <?= $worker['name'] ?>
                                    </div>
                                </td>
                                <td>Worker</td>
                                <td><span class="badge bg-success"><?= number_format($worker['total_income'], 0) ?> UGX</span></td>
                                <?php if($session_user_data->groups !== 'Worker'): ?>
                                <td><span class="badge bg-warning"><?= number_format($worker['company_60'], 0) ?> UGX</span></td>
                                <?php endif; ?>
                                <td><span class="badge bg-info"><?= number_format($worker['worker_40'], 0) ?> UGX</span></td>
                                <td><span class="badge bg-danger"><?= number_format($worker['paid_liquidations'], 0) ?> UGX</span></td>
                                <td><span class="badge bg-warning"><?= number_format($worker['pending_liquidations'], 0) ?> UGX</span></td>
                                <td><span class="badge bg-primary"><?= number_format($worker['available_amount'], 0) ?> UGX</span></td>
                                <?php if($session_user_data->groups !== 'Worker'): ?>
                                <td>
                                    <?php if($worker['available_amount'] > 0): ?>
                                    <input type="hidden" id="worker_<?= $worker['user_id'] ?>_name" value="<?= $worker['name'] ?>">
                                    <input type="hidden" id="worker_<?= $worker['user_id'] ?>_available" value="<?= $worker['available_amount'] ?>">
                                    <button class="btn btn-primary btn-sm" onclick="openLiquidation(<?= $worker['user_id'] ?>)">
                                        <i class="ti-wallet"></i> Liquidate
                                    </button>
                                    <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="ti-wallet"></i> No Balance
                                    </button>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php 
                            $counter++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="mdi mdi-information me-2"></i>
                        No paid entries found for this week (<strong><?= $weekRange['label'] ?></strong>).
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- Liquidation Modal -->
<div class="modal fade" id="liquidationModal" tabindex="-1" aria-labelledby="liquidationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-half modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liquidationModalLabel">Employee Liquidation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="liquidationForm" method="POST" action="">
                    <input type="hidden" name="request" value="liquidate-worker">
                    <input type="hidden" name="worker_id" id="worker_id">
                    
                    <div class="mb-3">
                        <label for="workerName" class="form-label">Worker Name</label>
                        <input type="text" class="form-control" id="workerName" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="availableAmount" class="form-label">Available Amount</label>
                        <input type="text" class="form-control" id="availableAmount" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="liquidationAmount" class="form-label">Amount to Liquidate <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="liquidation_amount" id="liquidationAmount" placeholder="Enter amount" step="1" min="0" required>
                        <small class="text-muted">Maximum: <span id="maxAmount"></span></small>
                    </div>

                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select" name="payment_method" id="paymentMethod" required>
                            <option value="">Select payment method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                            <option value="mobile_money">Mobile Money</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="liquidationDate" class="form-label">Liquidation Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="liquidation_date" id="liquidationDate" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description / Liquidation reason</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter any additional notes or description"></textarea>
                    </div>

                    <div class="alert alert-info mb-0" role="alert">
                        <strong>Note:</strong> Once liquidated, this amount will be marked as paid and deducted from the employee's available earnings.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" onclick="submitLiquidation()">
                    <i class="fas fa-check me-1"></i>Process Liquidation
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function openLiquidation(workerId) {
    // Get data from hidden inputs
    var workerName = document.getElementById('worker_' + workerId + '_name').value;
    var availableAmount = parseFloat(document.getElementById('worker_' + workerId + '_available').value);
    
    // Populate modal
    document.getElementById('workerName').value = workerName;
    document.getElementById('availableAmount').value = availableAmount.toLocaleString() + ' UGX';
    document.getElementById('maxAmount').textContent = availableAmount.toLocaleString() + ' UGX';
    document.getElementById('liquidationAmount').max = availableAmount;
    document.getElementById('worker_id').value = workerId;
    
    // Show modal
    var modal = new bootstrap.Modal(document.getElementById('liquidationModal'));
    modal.show();
}

function submitLiquidation() {
    var form = document.getElementById('liquidationForm');
    var amount = parseFloat(document.getElementById('liquidationAmount').value);
    var maxAmount = parseFloat(document.getElementById('liquidationAmount').max);
    
    if (amount > maxAmount) {
        alert('Liquidation amount cannot exceed available amount of ' + maxAmount.toLocaleString() + ' UGX');
        return false;
    }
    
    if (amount <= 0) {
        alert('Please enter a valid amount');
        return false;
    }
    
    form.submit();
}
</script>