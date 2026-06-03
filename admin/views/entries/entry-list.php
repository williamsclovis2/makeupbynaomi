<!-- start page title -->
<style>
/* ══════════════════════════════════════════════════════════════
   DROPDOWN FIX
══════════════════════════════════════════════════════════════ */
.table-responsive {
    overflow-x: auto !important;
    overflow-y: visible !important;
}

.table-entries tbody td:last-child {
    overflow: visible !important;
    position: relative !important;
}

.dropdown-act {
    position: relative !important;
    display: inline-block !important;
    z-index: auto !important;
}

/* Override Bootstrap 5 popper — reset inset/transform then force below button */
.dropdown-act .dropdown-menu {
    position: absolute !important;
    inset: auto !important;
    transform: none !important;
    top: 100% !important;
    bottom: auto !important;
    right: 0 !important;
    left: auto !important;
    margin-top: 2px !important;
    min-width: 175px;
    z-index: 9999 !important;
}

/* ══════════════════════════════════════════════════════════════
   TABLE
══════════════════════════════════════════════════════════════ */
.table-entries thead th,
.table-entries tbody td {
    white-space: nowrap;
    vertical-align: middle;
    font-size: 13px;
}

/* ══════════════════════════════════════════════════════════════
   PAGINATION
══════════════════════════════════════════════════════════════ */
.entries-pagination {
    display: flex; align-items: center; gap: 5px; flex-wrap: wrap;
}
.entries-pagination button {
    min-width: 36px; height: 34px; padding: 0 11px;
    border: 1px solid #dee2e6; border-radius: 6px;
    background: #fff; color: #495057; font-size: 13px;
    cursor: pointer;
    transition: background .15s, color .15s, border-color .15s;
    line-height: 1;
}
.entries-pagination button:hover:not(:disabled) {
    background: #d4af37; border-color: #d4af37; color: #fff;
}
.entries-pagination button.pg-active {
    background: #d4af37; border-color: #d4af37; color: #fff; font-weight: 700;
}
.entries-pagination button:disabled { opacity: .4; cursor: not-allowed; }
.pg-info { font-size: 13px; color: #6c757d; }

/* ══════════════════════════════════════════════════════════════
   EXPAND BUTTON
══════════════════════════════════════════════════════════════ */
.btn-expand {
    width: 26px; height: 26px;
    border: 1px solid #ced4da; border-radius: 5px;
    background: #fff; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 16px; font-weight: 700; color: #6c757d;
    transition: background .15s, color .15s, border-color .15s;
    vertical-align: middle; line-height: 1; padding: 0;
}
.btn-expand:hover,
.btn-expand.is-open { background: #d4af37; border-color: #d4af37; color: #fff; }

/* ══════════════════════════════════════════════════════════════
   DETAIL PANEL
══════════════════════════════════════════════════════════════ */
.detail-row td { padding: 0 !important; border-top: none !important; }
.detail-inner {
    overflow: hidden; max-height: 0;
    transition: max-height .28s ease;
}
.detail-inner.is-open { max-height: 500px; }
.detail-panel {
    background: #f8f9fa;
    border-left: 3px solid #d4af37;
    padding: 14px 18px;
    margin: 0 0 6px 40px;
    border-radius: 0 6px 6px 0;
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 10px 24px;
}
.detail-item label {
    font-size: 10px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .6px; color: #aaa; margin-bottom: 2px; display: block;
}
.detail-item span { font-size: 13px; color: #343a40; }
.collab-chip {
    display: inline-block; background: #e8f5e9; color: #2e7d32;
    border-radius: 4px; padding: 2px 8px; margin: 2px 2px 2px 0; font-size: 11px;
}
</style>

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">All Entries</h6>
            <?php include 'views'._.'includes/timer'.PL;?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-primary" href="<?=DNADMIN?>/app/entries/new">
                    <i class="mdi mdi-plus me-2"></i> Add Entry
                </a>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<?php
$db = DB::getInstance();

$sql    = "SELECT * FROM entries WHERE 1=1";
$params = array();

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $sql     .= " AND user_name LIKE ?";
    $params[] = '%' . $_GET['keyword'] . '%';
}
if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
    $sql     .= " AND created_date >= ?";
    $params[] = $_GET['from_date'];
}
if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
    $sql     .= " AND created_date <= ?";
    $params[] = $_GET['to_date'];
}

$sql .= " ORDER BY created_date DESC, created_time DESC";

$entriesQuery = $db->query($sql, $params);
$all_entries  = $entriesQuery->results();

$workersQuery = $db->query(
    "SELECT ID, firstname, lastname FROM app_users WHERE (groups = 'Worker' OR groups = 'Sub-admin' OR groups = 'Admin') AND (state = 'active' OR state = 'Activated') ORDER BY firstname ASC",
    array()
);
$all_workers = $workersQuery->results();
?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Entries List</h4>

                <!-- Filter Form -->
                <div class="col-xs-12 col-sm-12 mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk"   value="entries">
                        <input type="hidden" name="branch"  value="list">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">Keyword</label>
                                    <input type="text" name="keyword" class="form-control"
                                        placeholder="Search by worker name"
                                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="submit" name="search"
                                        class="btn btn-primary waves-effect waves-light">
                                        <i class="ti-search"></i> Search
                                    </button>
                                    <a href="<?=DNADMIN?>/app/entries/list" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if(count($all_entries) > 0): ?>

                <!-- Top pagination bar -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <span class="pg-info" id="pg-info-top"></span>
                    <div class="entries-pagination" id="pg-top"></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-entries mb-0" id="entries-table">
                        <thead id="table-head">
                            <tr>
                                <th style="width:36px;"></th>
                                <th>#</th>
                                <th>Date</th>
                                <th>Worker</th>
                                <th>Service</th>
                                <th>Amount (UGX)</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="entries-tbody">
                        <?php
                        $counter = 1;
                        foreach($all_entries as $entry):
                            $collabQuery   = $db->query("SELECT * FROM entry_collaborators WHERE entry_id = ?", array($entry->id));
                            $collaborators = $collabQuery->results();
                            $service_display = ucfirst(str_replace('_', ' ', $entry->service_type));

                            $collab_data = [];
                            foreach($collaborators as $c) {
                                $collab_data[] = ['user_id' => $c->user_id, 'amount' => $c->amount];
                            }

                            $collab_html = '';
                            if(count($collaborators) > 0) {
                                foreach($collaborators as $col) {
                                    $collab_html .= '<span class="collab-chip">'
                                        . htmlspecialchars($col->user_name)
                                        . ': ' . number_format($col->amount, 0) . ' UGX</span>';
                                }
                            } else {
                                $collab_html = '<span style="color:#aaa;font-size:12px;">None</span>';
                            }

                            switch($entry->status) {
                                case 'pending':   $bc='bg-warning text-dark'; $bl='Pending';   break;
                                case 'completed': $bc='bg-info text-dark';    $bl='Completed'; break;
                                case 'paid':      $bc='bg-success';           $bl='Paid';      break;
                                case 'cancelled': $bc='bg-danger';            $bl='Cancelled'; break;
                                default:          $bc='bg-secondary';         $bl='Unknown';
                            }
                        ?>
                        <!-- MAIN ROW -->
                        <tr class="entry-main-row" data-entry-id="<?= $entry->id ?>">
                            <td style="text-align:center;">
                                <button class="btn-expand"
                                    data-target="detail-<?= $entry->id ?>"
                                    type="button"
                                    title="Show details">+</button>
                            </td>
                            <td><?= $counter ?></td>
                            <td>
                                <?= date('d/m/Y', strtotime($entry->created_date)) ?><br>
                                <small class="text-muted"><?= date('H:i', strtotime($entry->created_time)) ?></small>
                            </td>
                            <td><?= htmlspecialchars($entry->user_name) ?></td>
                            <td><?= htmlspecialchars($service_display) ?></td>
                            <td><strong><?= number_format($entry->total_amount, 0) ?></strong></td>
                            <td><span class="badge <?= $bc ?>"><?= $bl ?></span></td>
                            <td>
                                <span class="badge <?= $entry->entry_type=='collab' ? 'bg-primary' : 'bg-secondary' ?>">
                                    <?= $entry->entry_type=='collab' ? 'Collab' : 'Solo' ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 align-items-center">
                                    <!-- Edit -->
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary btn-edit-entry"
                                        title="Edit entry"
                                        data-id="<?= $entry->id ?>"
                                        data-user_id="<?= $entry->user_id ?>"
                                        data-service_type="<?= htmlspecialchars($entry->service_type) ?>"
                                        data-total_amount="<?= $entry->total_amount ?>"
                                        data-payment_method="<?= htmlspecialchars($entry->payment_method) ?>"
                                        data-user_final_amount="<?= $entry->user_final_amount ?>"
                                        data-notes="<?= htmlspecialchars($entry->notes) ?>"
                                        data-status="<?= $entry->status ?>"
                                        data-entry_type="<?= $entry->entry_type ?>"
                                        data-collaborators='<?= json_encode($collab_data) ?>'
                                        data-bs-toggle="modal"
                                        data-bs-target="#editEntryModal">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <!-- Status dropdown -->
                                    <div class="dropdown dropdown-act">
                                        <button class="btn btn-sm btn-outline-secondary"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            data-bs-reference="parent"
                                            data-bs-offset="0,2"
                                            aria-expanded="false"
                                            title="Change status">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end entry-action-menu shadow-sm">
                                            <?php if($entry->status != 'completed'): ?>
                                            <li>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="request"  value="entry-status">
                                                    <input type="hidden" name="entry-id" value="<?= $entry->id ?>">
                                                    <button type="submit" name="completed" class="dropdown-item">
                                                        <i class="mdi mdi-check text-info me-1"></i> Mark Completed
                                                    </button>
                                                </form>
                                            </li>
                                            <?php endif; ?>
                                            <?php if($entry->status != 'paid'): ?>
                                            <li>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="request"  value="entry-status">
                                                    <input type="hidden" name="entry-id" value="<?= $entry->id ?>">
                                                    <button type="submit" name="paid" class="dropdown-item">
                                                        <i class="mdi mdi-cash text-success me-1"></i> Mark Paid
                                                    </button>
                                                </form>
                                            </li>
                                            <?php endif; ?>
                                            <?php if($entry->status != 'pending'): ?>
                                            <li>
                                                <form method="POST" action="">
                                                    <input type="hidden" name="request"  value="entry-status">
                                                    <input type="hidden" name="entry-id" value="<?= $entry->id ?>">
                                                    <button type="submit" name="pending" class="dropdown-item">
                                                        <i class="mdi mdi-clock-outline text-warning me-1"></i> Mark Pending
                                                    </button>
                                                </form>
                                            </li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form method="POST" action=""
                                                    onsubmit="return confirm('Cancel this entry?');">
                                                    <input type="hidden" name="request"  value="entry-status">
                                                    <input type="hidden" name="entry-id" value="<?= $entry->id ?>">
                                                    <button type="submit" name="cancelled" class="dropdown-item text-danger">
                                                        <i class="mdi mdi-delete me-1"></i> Cancel Entry
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- DETAIL ROW — always in the DOM, never display:none at init -->
                        <tr class="detail-row">
                            <td colspan="9">
                                <div class="detail-inner" id="detail-<?= $entry->id ?>">
                                    <div class="detail-panel">
                                        <div class="detail-grid">
                                            <div class="detail-item">
                                                <label>Worker Share</label>
                                                <span><?= number_format($entry->user_final_amount, 0) ?> UGX</span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Payment Method</label>
                                                <span><?= !empty($entry->payment_method) ? htmlspecialchars(ucfirst(str_replace('_',' ',$entry->payment_method))) : '—' ?></span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Full Timestamp</label>
                                                <span><?= date('d M Y', strtotime($entry->created_date)) ?>&nbsp;<?= date('H:i:s', strtotime($entry->created_time)) ?></span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Raw Service</label>
                                                <span><?= htmlspecialchars($entry->service_type) ?></span>
                                            </div>
                                            <div class="detail-item" style="grid-column:span 2;">
                                                <label>Collaborators</label>
                                                <div><?= $collab_html ?></div>
                                            </div>
                                            <div class="detail-item" style="grid-column:span 2;">
                                                <label>Notes</label>
                                                <span><?= !empty($entry->notes) ? htmlspecialchars($entry->notes) : '—' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php $counter++; endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bottom pagination bar -->
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                    <span class="pg-info" id="pg-info-bottom"></span>
                    <div class="entries-pagination" id="pg-bottom"></div>
                </div>

                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> No entries found.
                        <a href="<?=DNADMIN?>/app/entries/new">Add your first entry</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<!-- ============================================================ -->
<!-- Edit Entry Modal                                             -->
<!-- ============================================================ -->
<div class="modal fade" id="editEntryModal" tabindex="-1" aria-labelledby="editEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEntryModalLabel">
                    <i class="mdi mdi-pencil me-2"></i>Edit Entry
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" id="editEntryForm">
                <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                    <input type="hidden" name="request"  value="entry-edit">
                    <input type="hidden" name="entry-id" id="edit_entry_id">
                    <p class="text-danger mb-3"><small>* All fields are mandatory except notes</small></p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Worker <span class="text-danger">*</span></label>
                            <select name="register-user_id" id="edit_user_id" class="form-select" required>
                                <option value="">[ -- select worker -- ]</option>
                                <?php foreach($all_workers as $w): ?>
                                    <option value="<?= $w->ID ?>">
                                        <?= htmlspecialchars($w->firstname . ' ' . $w->lastname) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="register-status" id="edit_status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="paid">Paid</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Service Type <span class="text-danger">*</span></label>
                            <input type="text" name="register-service_type" id="edit_service_type"
                                class="form-control" placeholder="e.g. Manicure, Pedicure" required>
                            <small class="text-muted">Comma-separated for multiple services</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" id="edit_payment_method" class="form-select">
                                <option value="">Select payment method</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="mobile_money">Mobile Money</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Amount Charged (UGX) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="register-amount" id="edit_total_amount"
                                class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Worker Share (UGX) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="register-user_final_amount" id="edit_user_final_amount"
                                class="form-control" placeholder="0" required>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_collaboration_check"
                                    name="register-collaboration_check" value="1">
                                <label class="form-check-label" for="edit_collaboration_check">
                                    Worked with another worker?
                                </label>
                            </div>
                        </div>
                        <div class="col-12" id="edit_coworkers_wrapper" style="display:none;">
                            <label class="form-label">Select Coworker(s)</label>
                            <select class="form-select" id="edit_coworkers" name="register-coworkers[]" multiple>
                                <?php foreach($all_workers as $w): ?>
                                    <option value="<?= $w->ID ?>">
                                        <?= htmlspecialchars($w->firstname . ' ' . $w->lastname) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Hold Ctrl / Cmd to select multiple</small>
                        </div>
                        <div class="col-12" id="edit_collab_amounts_wrapper" style="display:none;">
                            <label class="form-label">Collaboration Amounts (UGX)</label>
                            <div id="edit_collab_amount_inputs">
                                <?php foreach($all_workers as $w): ?>
                                <div class="mb-2 edit-collab-amount-row" data-user-id="<?= $w->ID ?>" style="display:none;">
                                    <label class="form-label">
                                        <?= htmlspecialchars($w->firstname . ' ' . $w->lastname) ?> Amount
                                    </label>
                                    <input type="number" step="0.01" class="form-control edit-collab-input"
                                        name="register-collab_amounts[<?= $w->ID ?>]"
                                        placeholder="Amount for <?= htmlspecialchars($w->firstname) ?>"
                                        disabled>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes (optional)</label>
                            <textarea name="register-notes" id="edit_notes" class="form-control"
                                rows="3" placeholder="Any additional notes"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ============================================================ -->
<!-- /Edit Entry Modal                                            -->
<!-- ============================================================ -->


<script>
(function () {
    'use strict';

    /* ============================================================
       1. EXPAND / COLLAPSE
    ============================================================ */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-expand');
        if (!btn) return;
        var targetId = btn.getAttribute('data-target');
        var inner    = document.getElementById(targetId);
        if (!inner) return;
        var opening = !inner.classList.contains('is-open');
        inner.classList.toggle('is-open', opening);
        btn.classList.toggle('is-open', opening);
        btn.textContent = opening ? '−' : '+';
    });


    /* ============================================================
       2. DROPDOWN — strip ALL Bootstrap/Popper inline styles the
          moment the menu becomes visible, then lock it below the button
    ============================================================ */
    document.addEventListener('shown.bs.dropdown', function (e) {
        var toggle = e.relatedTarget;
        if (!toggle) return;
        var wrap = toggle.closest('.dropdown-act');
        if (!wrap) return;
        var menu = wrap.querySelector('.dropdown-menu');
        if (!menu) return;

        /* Nuke every inline style Popper may have injected */
        menu.removeAttribute('style');

        /* Re-apply only what we need */
        menu.style.cssText = [
            'position: absolute !important',
            'top: 100% !important',
            'bottom: auto !important',
            'right: 0 !important',
            'left: auto !important',
            'transform: none !important',
            'inset: auto !important',
            'margin-top: 2px !important',
            'min-width: 175px',
            'z-index: 9999 !important'
        ].join(';');
    });


    /* ============================================================
       3. PAGINATION
    ============================================================ */
    var PER_PAGE    = 20;
    var currentPage = 1;

    var tbody = document.getElementById('entries-tbody');
    if (!tbody) return;

    var pairs = [];
    var allTR = Array.prototype.slice.call(tbody.rows);
    for (var i = 0; i < allTR.length; i++) {
        if (allTR[i].classList.contains('entry-main-row')) {
            var next = allTR[i + 1];
            pairs.push({
                main:   allTR[i],
                detail: (next && next.classList.contains('detail-row')) ? next : null
            });
        }
    }

    var total      = pairs.length;
    var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

    function showPage(page) {
        currentPage = Math.max(1, Math.min(page, totalPages));
        var start   = (currentPage - 1) * PER_PAGE;
        var end     = start + PER_PAGE;

        pairs.forEach(function (pair, idx) {
            var visible = idx >= start && idx < end;
            pair.main.style.display = visible ? '' : 'none';
            if (pair.detail) {
                if (visible) {
                    pair.detail.style.display = '';
                } else {
                    pair.detail.style.display = 'none';
                    var inner  = pair.detail.querySelector('.detail-inner');
                    var expBtn = pair.main.querySelector('.btn-expand');
                    if (inner)  inner.classList.remove('is-open');
                    if (expBtn) { expBtn.classList.remove('is-open'); expBtn.textContent = '+'; }
                }
            }
        });

        buildPagination();
        updateInfo();
    }

    function buildPagination() {
        ['pg-top', 'pg-bottom'].forEach(function (id) {
            var wrap = document.getElementById(id);
            if (!wrap) return;
            wrap.innerHTML = '';

            wrap.appendChild(mkBtn('&laquo; Prev', currentPage === 1, function () {
                showPage(currentPage - 1);
            }));

            pageNums(currentPage, totalPages).forEach(function (p) {
                if (p === '…') {
                    wrap.appendChild(mkBtn('…', true, null));
                } else {
                    var b = mkBtn(String(p), false, (function (pg) {
                        return function () { showPage(pg); };
                    }(p)));
                    if (p === currentPage) b.classList.add('pg-active');
                    wrap.appendChild(b);
                }
            });

            wrap.appendChild(mkBtn('Next &raquo;', currentPage === totalPages, function () {
                showPage(currentPage + 1);
            }));
        });
    }

    function mkBtn(html, disabled, onClick) {
        var b       = document.createElement('button');
        b.innerHTML = html;
        b.type      = 'button';
        b.disabled  = !!disabled;
        if (onClick) b.addEventListener('click', onClick);
        return b;
    }

    function updateInfo() {
        var s    = (currentPage - 1) * PER_PAGE + 1;
        var e    = Math.min(currentPage * PER_PAGE, total);
        var text = 'Showing ' + s + ' \u2013 ' + e + ' of ' + total + ' entries';
        ['pg-info-top', 'pg-info-bottom'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.textContent = text;
        });
    }

    function pageNums(cur, tot) {
        if (tot <= 7) {
            var a = [];
            for (var i = 1; i <= tot; i++) a.push(i);
            return a;
        }
        var p = [1];
        if (cur > 3) p.push('…');
        for (var n = Math.max(2, cur - 1); n <= Math.min(tot - 1, cur + 1); n++) p.push(n);
        if (cur < tot - 2) p.push('…');
        p.push(tot);
        return p;
    }

    if (total > 0) { showPage(1); }


    /* ============================================================
       4. EDIT MODAL
    ============================================================ */
    var collabCheck      = document.getElementById('edit_collaboration_check');
    var coworkersWrapper = document.getElementById('edit_coworkers_wrapper');
    var amountsWrapper   = document.getElementById('edit_collab_amounts_wrapper');
    var coworkersSelect  = document.getElementById('edit_coworkers');
    var amountRows       = document.querySelectorAll('.edit-collab-amount-row');
    var amountInputs     = document.querySelectorAll('.edit-collab-input');

    function syncCollabUI() {
        var on = collabCheck && collabCheck.checked;
        if (coworkersWrapper) coworkersWrapper.style.display = on ? '' : 'none';
        if (amountsWrapper)   amountsWrapper.style.display   = on ? '' : 'none';
        if (!on) {
            amountInputs.forEach(function (inp) { inp.disabled = true; });
            if (coworkersSelect) {
                Array.from(coworkersSelect.options).forEach(function (o) { o.selected = false; });
            }
            amountRows.forEach(function (r) { r.style.display = 'none'; });
        }
    }

    function syncAmountRows() {
        if (!coworkersSelect) return;
        var sel = Array.from(coworkersSelect.selectedOptions).map(function (o) { return o.value; });
        amountRows.forEach(function (row) {
            var uid   = row.dataset.userId;
            var input = row.querySelector('.edit-collab-input');
            var show  = sel.indexOf(uid) !== -1;
            row.style.display = show ? '' : 'none';
            if (input) {
                input.disabled = !show;
                if (!show) input.value = '';
            }
        });
    }

    if (collabCheck)     collabCheck.addEventListener('change', syncCollabUI);
    if (coworkersSelect) coworkersSelect.addEventListener('change', syncAmountRows);

    document.querySelectorAll('.btn-edit-entry').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('edit_entry_id').value          = this.dataset.id;
            document.getElementById('edit_user_id').value           = this.dataset.user_id;
            document.getElementById('edit_service_type').value      = this.dataset.service_type;
            document.getElementById('edit_total_amount').value      = this.dataset.total_amount;
            document.getElementById('edit_payment_method').value    = this.dataset.payment_method;
            document.getElementById('edit_user_final_amount').value = this.dataset.user_final_amount;
            document.getElementById('edit_notes').value             = this.dataset.notes;
            document.getElementById('edit_status').value            = this.dataset.status;

            var isCollab = this.dataset.entry_type === 'collab';
            if (collabCheck) collabCheck.checked = isCollab;
            syncCollabUI();

            if (isCollab) {
                var collabs       = JSON.parse(this.dataset.collaborators || '[]');
                var collabUserIds = collabs.map(function (c) { return String(c.user_id); });

                if (coworkersSelect) {
                    Array.from(coworkersSelect.options).forEach(function (opt) {
                        opt.selected = collabUserIds.indexOf(opt.value) !== -1;
                    });
                    syncAmountRows();
                }

                collabs.forEach(function (c) {
                    var row   = document.querySelector('.edit-collab-amount-row[data-user-id="' + c.user_id + '"]');
                    var input = row ? row.querySelector('.edit-collab-input') : null;
                    if (input) {
                        input.value       = c.amount;
                        input.disabled    = false;
                        row.style.display = '';
                    }
                });
            }
        });
    });

}());
</script>