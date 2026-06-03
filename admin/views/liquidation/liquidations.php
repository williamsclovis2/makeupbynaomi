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
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $filters['user_id'] = $_GET['user_id'];
}
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}
if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
    $filters['from_date'] = $_GET['from_date'];
}
if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
    $filters['to_date'] = $_GET['to_date'];
}

// Get all liquidations
$liquidations = LiquidationController::getAllLiquidations($filters);

// Get all workers for filter dropdown
$db = DB::getInstance();
$workersQuery = $db->query("SELECT ID, firstname, lastname FROM app_users WHERE state = 'activated' ORDER BY firstname ASC");
$workers = $workersQuery->results();
?>

<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">All Liquidations</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-primary" href="<?=DNADMIN?>/dashboard">
                    <i class="mdi mdi-arrow-left me-2"></i> Back to Dashboard
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
                <h4 class="card-title mb-4">Liquidations List</h4>
                
                <!-- Filter Form -->
                <div class="col-xs-12 col-sm-12 mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk" value="liquidations">
                        <input type="hidden" name="branch" value="list">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">Worker</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">All Workers</option>
                                        <?php foreach($workers as $worker): ?>
                                            <option value="<?= $worker->ID ?>" <?= (isset($_GET['user_id']) && $_GET['user_id'] == $worker->ID) ? 'selected' : '' ?>>
                                                <?= $worker->firstname . ' ' . $worker->lastname ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="filter-input">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                                        <option value="paid" <?= (isset($_GET['status']) && $_GET['status'] == 'paid') ? 'selected' : '' ?>>Paid</option>
                                        <option value="cancelled" <?= (isset($_GET['status']) && $_GET['status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="filter-input">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="<?= @$_GET['from_date'] ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="filter-input">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="<?= @$_GET['to_date'] ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="submit" name="search" class="btn btn-primary waves-effect waves-light">
                                        <i class="ti-search"></i> Search
                                    </button>
                                    <a href="<?=DNADMIN?>/app/liquidations/list" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if(count($liquidations) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th scope="col">#NO</th>
                                <th scope="col">Worker</th>
                                <th scope="col">Total Earnings</th>
                                <th scope="col">Amount Liquidated</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Liquidation Date</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $counter = 1;
                            foreach($liquidations as $liquidation): 
                                // Status badge
                                $status_badge = '';
                                switch($liquidation->status) {
                                    case 'pending':
                                        $status_badge = '<span class="badge bg-warning">Pending</span>';
                                        break;
                                    case 'paid':
                                        $status_badge = '<span class="badge bg-success">Paid</span>';
                                        break;
                                    case 'cancelled':
                                        $status_badge = '<span class="badge bg-danger">Cancelled</span>';
                                        break;
                                    default:
                                        $status_badge = '<span class="badge bg-secondary">Unknown</span>';
                                }
                            ?>
                            <tr>
                                <th scope="row"><?= $counter ?></th>
                                <td><?= $liquidation->user_name ?></td>
                                <td><?= number_format($liquidation->total_earnings, 0) ?> UGX</td>
                                <td><strong><?= number_format($liquidation->amount_liquidated, 0) ?> UGX</strong></td>
                                <td><?= ucfirst(str_replace('_', ' ', $liquidation->payment_method)) ?></td>
                                <td><?= date('d-m-Y', strtotime($liquidation->liquidation_date)) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($liquidation->created_date . ' ' . $liquidation->created_time)) ?></td>
                                <td>
                                    <?php if(!empty($liquidation->description)): ?>
                                        <span title="<?= htmlspecialchars($liquidation->description) ?>" style="cursor: pointer;">
                                            <?= substr($liquidation->description, 0, 30) ?><?= strlen($liquidation->description) > 30 ? '...' : '' ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= $status_badge ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <i class="mdi mdi-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Status Changes -->
                                            <?php if($liquidation->status != 'paid'): ?>
                                            <form method="POST" action="" style="display: inline;">
                                                <input type="hidden" name="request" value="liquidation-status">
                                                <input type="hidden" name="liquidation-id" value="<?= $liquidation->id ?>">
                                                <button type="submit" name="paid" class="dropdown-item">
                                                    <i class="mdi mdi-cash text-success"></i> Mark as Paid
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if($liquidation->status != 'pending'): ?>
                                            <form method="POST" action="" style="display: inline;">
                                                <input type="hidden" name="request" value="liquidation-status">
                                                <input type="hidden" name="liquidation-id" value="<?= $liquidation->id ?>">
                                                <button type="submit" name="pending" class="dropdown-item">
                                                    <i class="mdi mdi-clock-outline text-warning"></i> Mark as Pending
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                            
                                            <?php if($liquidation->status != 'cancelled'): ?>
                                            <form method="POST" action="" style="display: inline;" onsubmit="return confirm('Are you sure you want to cancel this liquidation?');">
                                                <input type="hidden" name="request" value="liquidation-status">
                                                <input type="hidden" name="liquidation-id" value="<?= $liquidation->id ?>">
                                                <button type="submit" name="cancelled" class="dropdown-item text-danger">
                                                    <i class="mdi mdi-close-circle"></i> Cancel Liquidation
                                                </button>
                                            </form>
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
                    <div class="alert alert-info" role="alert">
                        <i class="mdi mdi-information"></i> No liquidations found with the selected filters.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- end row -->