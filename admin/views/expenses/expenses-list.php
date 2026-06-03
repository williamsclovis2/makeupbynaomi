<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">All Expenses</h6>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-primary" href="<?=DNADMIN?>/app/expenses/new">
                    <i class="mdi mdi-plus me-2"></i> Add Expense
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<style>
    .expense-action-btn {
        padding: 2px 8px;
        font-size: 12px;
        white-space: nowrap;
    }
    .expense-dropdown-menu {
        min-width: 190px;
        font-size: 13px;
        padding: 4px 0;
    }
    .expense-dropdown-menu .dropdown-item {
        padding: 5px 14px;
        font-size: 13px;
    }
    .expense-dropdown-menu .dropdown-item i {
        width: 16px;
        display: inline-block;
        text-align: center;
    }
    .table-responsive { overflow-x: auto; }
    .table td, .table th { vertical-align: middle; }
    .dropdown-menu-end { right: 0; left: auto; }
    /* Badge for auto-paid salon expenses */
    .badge-salon-paid { background-color: #0d6efd; }
</style>

<?php
Functions::flashMsg();

global $session_user_data, $session_user_ID;

$db = DB::getInstance();
$workers_query = $db->query(
    "SELECT ID, firstname, lastname FROM app_users 
     WHERE (groups = 'Worker' OR groups = 'Admin') 
     AND (state = 'active' OR state = 'Activated') 
     ORDER BY firstname ASC"
);
$all_workers = $workers_query->results();

// ── Build filters ────────────────────────────────────────────────────────────
$filters = array();
if (!empty($_GET['keyword']))      $filters['keyword']      = $_GET['keyword'];
if (!empty($_GET['expense_type'])) $filters['expense_type'] = $_GET['expense_type'];
if (!empty($_GET['status']))       $filters['status']       = $_GET['status'];
if (!empty($_GET['from_date']))    $filters['from_date']    = $_GET['from_date'];
if (!empty($_GET['to_date']))      $filters['to_date']      = $_GET['to_date'];

if (!empty($_GET['worker_id'])) {
    if ($_GET['worker_id'] == 'salon') {
        $filters['salon_only'] = true;
    } else {
        $filters['user_id'] = $_GET['worker_id'];
    }
}

// ── Query — always exclude cancelled ─────────────────────────────────────────
$sql    = "SELECT * FROM expenses WHERE status != 'cancelled'";
$params = array();

if (!empty($filters['keyword'])) {
    $sql     .= " AND (user_name LIKE ? OR category LIKE ? OR reason LIKE ?)";
    $kw       = '%' . $filters['keyword'] . '%';
    $params[] = $kw; $params[] = $kw; $params[] = $kw;
}
if (!empty($filters['salon_only'])) {
    $sql .= " AND user_id IS NULL";
} elseif (!empty($filters['user_id'])) {
    $sql     .= " AND user_id = ?";
    $params[] = $filters['user_id'];
}
if (!empty($filters['expense_type'])) {
    $sql     .= " AND expense_type = ?";
    $params[] = $filters['expense_type'];
}
if (!empty($filters['status']) && $filters['status'] !== 'cancelled') {
    $sql     .= " AND status = ?";
    $params[] = $filters['status'];
}
if (!empty($filters['from_date'])) {
    $sql     .= " AND created_date >= ?";
    $params[] = $filters['from_date'];
}
if (!empty($filters['to_date'])) {
    $sql     .= " AND created_date <= ?";
    $params[] = $filters['to_date'];
}
$sql .= " ORDER BY created_date DESC, created_time DESC";

$all_expenses = $db->query($sql, $params)->results();

// ── Calculate summary totals ──────────────────────────────────────────────────
// Box 1 – Total Expenses   : ALL expenses (any status except cancelled)
// Box 2 – Salon Expenses   : external + salon_supply (always liquidated)
// Box 3 – Worker Liquidated: internal expenses with status = liquidated
// Box 4 – Total Records    : count of displayed rows

$total_all_expenses    = 0;   // box 1
$total_salon_expenses  = 0;   // box 2  (external + salon_supply, auto-paid)
$total_worker_liquidated = 0; // box 3  (internal, liquidated)

$worker_totals = array();

foreach ($all_expenses as $expense) {
    $is_salon_type = ($expense->expense_type === 'external' || $expense->expense_type === 'salon_supply');

    // Box 1: everything
    $total_all_expenses += $expense->amount;

    // Box 2: salon expenses (external/salon_supply — always liquidated)
    if ($is_salon_type) {
        $total_salon_expenses += $expense->amount;
    }

    // Box 3: internal worker expenses that are liquidated
    if (!$is_salon_type && $expense->status === 'liquidated' && !empty($expense->user_id)) {
        $total_worker_liquidated += $expense->amount;
    }

    // Worker breakdown table (internal only)
    if (!empty($expense->user_id) && !$is_salon_type) {
        if (!isset($worker_totals[$expense->user_id])) {
            $worker_totals[$expense->user_id] = array(
                'name'       => $expense->user_name,
                'pending'    => 0,
                'waiting'    => 0,
                'liquidated' => 0,
                'total'      => 0, // liquidated only
            );
        }
        $worker_totals[$expense->user_id][$expense->status] += $expense->amount;
        if ($expense->status === 'liquidated') {
            $worker_totals[$expense->user_id]['total'] += $expense->amount;
        }
    }
}
?>

<!-- ── Summary Cards ────────────────────────────────────────────────────── -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <i class="mdi mdi-cash-multiple font-size-40"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Total Expenses</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($total_all_expenses, 0) ?> <span class="font-size-14">UGX</span></h4>
                    <small class="text-white-50">All active expenses (excl. cancelled)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-success text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <i class="mdi mdi-store font-size-40"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Salon Expenses</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($total_salon_expenses, 0) ?> <span class="font-size-14">UGX</span></h4>
                    <small class="text-white-50">External &amp; Salon Supply (auto-paid)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-info text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <i class="mdi mdi-account-multiple font-size-40"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Worker Liquidated</h5>
                    <h4 class="fw-medium font-size-24"><?= number_format($total_worker_liquidated, 0) ?> <span class="font-size-14">UGX</span></h4>
                    <small class="text-white-50">Internal expenses deducted from earnings</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-warning text-white">
            <div class="card-body">
                <div class="mb-4">
                    <div class="float-start mini-stat-img me-4">
                        <i class="mdi mdi-format-list-numbered font-size-40"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Total Records</h5>
                    <h4 class="fw-medium font-size-24"><?= count($all_expenses) ?></h4>
                    <small class="text-white-50">Active expense records</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Expenses List</h4>

                <!-- ── Filter Form ───────────────────────────────────────── -->
                <div class="mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk"   value="expenses">
                        <input type="hidden" name="branch"  value="list">

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Keyword</label>
                                <input type="text" name="keyword" class="form-control" placeholder="Search..." value="<?= @htmlspecialchars($_GET['keyword']) ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Worker</label>
                                <select name="worker_id" class="form-select">
                                    <option value="">All Workers</option>
                                    <option value="salon" <?= (@$_GET['worker_id'] == 'salon') ? 'selected' : '' ?>>🏪 Barclay Nails Salon</option>
                                    <option disabled>──────────────</option>
                                    <?php foreach($all_workers as $w): ?>
                                        <option value="<?= $w->ID ?>" <?= (@$_GET['worker_id'] == $w->ID) ? 'selected' : '' ?>>
                                            <?= $w->firstname . ' ' . $w->lastname ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Type</label>
                                <select name="expense_type" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="salon_supply" <?= (@$_GET['expense_type'] == 'salon_supply') ? 'selected' : '' ?>>💄 Salon Supply</option>
                                    <option value="internal"     <?= (@$_GET['expense_type'] == 'internal')     ? 'selected' : '' ?>>🏢 Internal</option>
                                    <option value="external"     <?= (@$_GET['expense_type'] == 'external')     ? 'selected' : '' ?>>📦 External</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending"    <?= (@$_GET['status'] == 'pending')    ? 'selected' : '' ?>>Pending</option>
                                    <option value="waiting"    <?= (@$_GET['status'] == 'waiting')    ? 'selected' : '' ?>>Waiting</option>
                                    <option value="liquidated" <?= (@$_GET['status'] == 'liquidated') ? 'selected' : '' ?>>Liquidated / Paid</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Date Range</label>
                                <div class="input-group">
                                    <input type="date" name="from_date" class="form-control" value="<?= @$_GET['from_date'] ?>">
                                    <span class="input-group-text">to</span>
                                    <input type="date" name="to_date"   class="form-control" value="<?= @$_GET['to_date'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="submit" name="search" class="btn btn-primary">
                                    <i class="ti-search"></i> Search
                                </button>
                                <a href="<?=DNADMIN?>/app/expenses/list" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- ── Worker Breakdown (internal expenses only) ─────────── -->
                <?php if(count($worker_totals) > 0): ?>
                <div class="mb-4">
                    <h5 class="mb-3">Internal Expenses by Worker</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Worker Name</th>
                                    <th class="text-end text-muted">Pending</th>
                                    <th class="text-end text-muted">Waiting</th>
                                    <th class="text-end">Liquidated</th>
                                    <th class="text-end"><strong>Total Liquidated</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($worker_totals as $wid => $totals): ?>
                                <tr>
                                    <td><?= htmlspecialchars($totals['name']) ?></td>
                                    <td class="text-end text-muted"><?= number_format($totals['pending'], 0) ?></td>
                                    <td class="text-end text-muted"><?= number_format($totals['waiting'], 0) ?></td>
                                    <td class="text-end"><strong><?= number_format($totals['liquidated'], 0) ?></strong></td>
                                    <td class="text-end"><strong><?= number_format($totals['total'], 0) ?> UGX</strong></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="table-active">
                                    <td><strong>TOTAL WORKER LIQUIDATED</strong></td>
                                    <td colspan="3"></td>
                                    <td class="text-end"><strong><?= number_format($total_worker_liquidated, 0) ?> UGX</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ── Main Expenses Table ───────────────────────────────── -->
                <?php if(count($all_expenses) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead id="table-head">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Worker/Entity</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Amount (UGX)</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $counter = 1;
                        foreach($all_expenses as $expense):

                            $is_salon_type = ($expense->expense_type === 'external' || $expense->expense_type === 'salon_supply');
                            $is_salon_entity = ($expense->user_id === NULL);

                            // Type display
                            switch($expense->expense_type) {
                                case 'salon_supply': $type_icon = '💄'; $type_text = 'Salon Supply'; break;
                                case 'internal':     $type_icon = '🏢'; $type_text = 'Internal';     break;
                                case 'external':     $type_icon = '📦'; $type_text = 'External';     break;
                                default:             $type_icon = '';   $type_text = ucfirst($expense->expense_type);
                            }

                            // Status badge — external/salon_supply show as "Paid" (they're auto-liquidated)
                            if ($is_salon_type) {
                                $status_badge = '<span class="badge bg-primary">Paid</span>';
                            } else {
                                switch($expense->status) {
                                    case 'pending':    $status_badge = '<span class="badge bg-warning">Pending</span>';    break;
                                    case 'waiting':    $status_badge = '<span class="badge bg-info">Waiting</span>';       break;
                                    case 'liquidated': $status_badge = '<span class="badge bg-success">Liquidated</span>'; break;
                                    default:           $status_badge = '<span class="badge bg-secondary">Unknown</span>';
                                }
                            }

                            $row_class = $is_salon_entity ? 'table-warning' : '';

                            // Action availability
                            // Edit: always allowed
                            $can_edit = true;
                            // Convert to liquidation: only internal, not yet liquidated
                            $can_liquidate = !$is_salon_type
                                             && !$is_salon_entity
                                             && $expense->status !== 'liquidated'
                                             && $expense->status !== 'cancelled';
                            // Cancel: only internal expenses that are not yet liquidated
                            $can_cancel = !$is_salon_type
                                          && $expense->status !== 'cancelled'
                                          && $expense->status !== 'liquidated';
                        ?>
                        <tr class="<?= $row_class ?>">
                            <th scope="row"><?= $counter ?></th>
                            <td><?= date('d-m-Y', strtotime($expense->created_date)) ?></td>
                            <td>
                                <?php if($is_salon_entity): ?>
                                    <strong>🏪 <?= htmlspecialchars($expense->user_name) ?></strong>
                                <?php else: ?>
                                    <?= htmlspecialchars($expense->user_name) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $type_icon ?> <?= $type_text ?></td>
                            <td><?= htmlspecialchars($expense->category) ?></td>
                            <td><strong><?= number_format($expense->amount, 0) ?></strong></td>
                            <td>
                                <?php if(!empty($expense->reason)): ?>
                                    <span title="<?= htmlspecialchars($expense->reason) ?>" style="cursor:pointer;">
                                        <?= htmlspecialchars(substr($expense->reason, 0, 30)) ?><?= strlen($expense->reason) > 30 ? '…' : '' ?>
                                    </span>
                                <?php else: ?> - <?php endif; ?>
                            </td>
                            <td><?= $status_badge ?></td>

                            <!-- Action -->
                            <td>
                                <div class="dropdown ">
                                    <button type="button dropdown-act" style="    border: 1px solid;   color: #000;"
                                            class="btn btn-sm btn-outline-secondary expense-action-btn dropdown-toggle"
                                            data-bs-toggle="dropdown"
                                            data-bs-boundary="viewport"
                                            aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end expense-dropdown-menu">

                                        <!-- EDIT (always) -->
                                        <li>
                                            <a class="dropdown-item" href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editModal<?= $expense->id ?>">
                                                <i class="mdi mdi-pencil text-primary"></i> Edit
                                            </a>
                                        </li>

                                        <!-- CONVERT TO LIQUIDATION (internal worker only) -->
                                        <?php if($can_liquidate): ?>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form method="POST" action=""
                                                  onsubmit="return confirm('Convert this expense to liquidation?\nThis will deduct <?= number_format($expense->amount, 0) ?> UGX from <?= addslashes(htmlspecialchars($expense->user_name)) ?>\'s earnings.');">
                                                <input type="hidden" name="request"    value="expense-liquidate">
                                                <input type="hidden" name="expense-id" value="<?= $expense->id ?>">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="mdi mdi-cash-multiple"></i> Convert to Liquidation
                                                </button>
                                            </form>
                                        </li>
                                        <?php endif; ?>

                                        <!-- CANCEL (internal only, not liquidated) -->
                                        <?php if($can_cancel): ?>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <form method="POST" action=""
                                                  onsubmit="return confirm('Are you sure you want to cancel this expense?');">
                                                <input type="hidden" name="request"    value="expense-status">
                                                <input type="hidden" name="expense-id" value="<?= $expense->id ?>">
                                                <button type="submit" name="cancelled" value="1" class="dropdown-item text-danger">
                                                    <i class="mdi mdi-close-circle"></i> Cancel Expense
                                                </button>
                                            </form>
                                        </li>
                                        <?php endif; ?>

                                        <?php if(!$can_liquidate && !$can_cancel && $is_salon_type): ?>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li><span class="dropdown-item text-muted fst-italic"><i class="mdi mdi-check-circle text-success"></i> Auto-paid on creation</span></li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $expense->id ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Expense #<?= $expense->id ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="">
                                        <input type="hidden" name="request"    value="expense-update">
                                        <input type="hidden" name="expense-id" value="<?= $expense->id ?>">

                                        <div class="modal-body">
                                            <?php if($is_salon_type): ?>
                                            <div class="alert alert-info py-2 mb-3">
                                                <i class="mdi mdi-information"></i>
                                                <strong>Salon/External expense</strong> — this was automatically marked as <strong>Paid</strong> when created.
                                                If you change the type to <em>Internal</em>, the status will be reset to <em>Pending</em>.
                                            </div>
                                            <?php endif; ?>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Worker/Entity</label>
                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($expense->user_name) ?>" readonly style="background-color:#e9ecef;">
                                                    <small class="text-muted">Cannot change worker after creation</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Expense Type <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="expense-expense_type" required>
                                                        <option value="salon_supply" <?= $expense->expense_type == 'salon_supply' ? 'selected' : '' ?>>💄 Salon Supply</option>
                                                        <option value="internal"     <?= $expense->expense_type == 'internal'     ? 'selected' : '' ?>>🏢 Internal</option>
                                                        <option value="external"     <?= $expense->expense_type == 'external'     ? 'selected' : '' ?>>📦 External</option>
                                                    </select>
                                                    <small class="text-muted">Changing to/from Internal will update status automatically</small>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="expense-category" value="<?= htmlspecialchars($expense->category) ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Amount (UGX) <span class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" class="form-control" name="expense-amount" value="<?= $expense->amount ?>" required min="1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="expense-reason" value="<?= htmlspecialchars($expense->reason) ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" rows="3" name="expense-description"><?= htmlspecialchars($expense->description) ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-content-save"></i> Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Modal -->

                        <?php $counter++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> No expenses found.
                        <a href="<?=DNADMIN?>/app/expenses/new">Add your first expense</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>