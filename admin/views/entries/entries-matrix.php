<?php
// Get matrix data
$matrix_result = WorkerMatrixController::getMatrixData();

if ($matrix_result->ERRORS) {
    echo '<div class="alert alert-danger">Error loading matrix: ' . $matrix_result->ERRORS_SCRIPT . '</div>';
    return;
}

$matrix_data = $matrix_result->data;
$workers     = $matrix_data['workers'];
$matrix      = $matrix_data['matrix'];
$totals      = $matrix_data['totals'];

// Workers list for the filter dropdown
$all_workers_list = WorkerMatrixController::getWorkersList();

// Active filter values
$filter_user_id   = isset($_GET['user_id'])   ? (int) $_GET['user_id']   : 0;
$filter_from_date = isset($_GET['from_date']) ? $_GET['from_date']       : '';
$filter_to_date   = isset($_GET['to_date'])   ? $_GET['to_date']         : '';

// Filter workers based on role - Worker sees only themselves
$display_workers = $workers;
$is_worker = ($session_user_data->groups === 'Worker');

if($is_worker) {
    $display_workers = array_filter($workers, function($w) use ($session_user_data) {
        return $w->ID == $session_user_data->ID;
    });

    // Filter matrix rows to only show services where this worker has an amount > 0
    $matrix = array_filter($matrix, function($row) use ($session_user_data) {
        $worker_data = isset($row['workers'][$session_user_data->ID]) ? $row['workers'][$session_user_data->ID] : null;
        return $worker_data && $worker_data['amount'] > 0;
    });
}
?>

<!-- start page title -->
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h6 class="page-title">Worker Matrix Report</h6>
            <?php include 'views'._.'includes/timer'.PL; ?>
        </div>
        <div class="col-md-4">
            <div class="float-end d-none d-md-block">
                <a class="btn btn-primary" href="<?= DNADMIN ?>/app/entries/new">
                    <i class="mdi mdi-plus me-2"></i> Add Entry
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
                <h4 class="card-title mb-4">Worker Earnings Matrix (Paid Entries Only)</h4>

                <!-- Filter Form -->
                <div class="col-xs-12 col-sm-12 mb-4">
                    <form action="" method="get" class="mainsearch-form">
                        <input type="hidden" name="request" value="app">
                        <input type="hidden" name="trunk"   value="entries">
                        <input type="hidden" name="branch"  value="matrix">
                        <div class="row">

                            <!-- Worker filter - hidden for Worker role -->
                            <?php if(!$is_worker): ?>
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">Worker</label>
                                    <select name="user_id" class="form-control">
                                        <option value="">— All Workers —</option>
                                        <?php foreach ($all_workers_list as $w): ?>
                                            <option value="<?= $w->ID ?>" <?= $filter_user_id == $w->ID ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($w->full_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- From date -->
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="<?= htmlspecialchars($filter_from_date) ?>">
                                </div>
                            </div>

                            <!-- To date -->
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="<?= htmlspecialchars($filter_to_date) ?>">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3">
                                <div class="filter-input">
                                    <label class="form-label">&nbsp;</label><br>
                                    <button type="submit" name="search" class="btn btn-primary waves-effect waves-light">
                                        <i class="ti-search"></i> Search
                                    </button>
                                    <a href="<?= DNADMIN ?>/app/entries/matrix" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <?php if (count($display_workers) > 0): ?>
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <table class="table table-hover table-bordered table-centered table-nowrap mb-0">
                            <thead id="table-head">
                                <tr>
                                    <th style="background: #d4af37; color: white;">SERVICES</th>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <th style="background: #d4af37; color: white;">
                                            <?= strtoupper(htmlspecialchars($worker->full_name)) ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (count($matrix) > 0): ?>
                                    <?php foreach ($matrix as $row): ?>
                                    <tr class="group-row">
                                        <td>
                                            <span class="services-td" style="font-weight: bold; color: #d4af37;">
                                                <?= strtoupper(htmlspecialchars($row['service_display'])) ?>
                                            </span>
                                            <br>
                                            <small style="color: #666;">
                                                <?= date('d/m/Y', strtotime($row['date'])) ?> –
                                                <?= date('H:i',   strtotime($row['time'])) ?>
                                            </small>
                                        </td>
                                        <?php foreach ($display_workers as $worker): ?>
                                            <td>
                                                <?php
                                                $worker_data = isset($row['workers'][$worker->ID]) ? $row['workers'][$worker->ID] : null;
                                                $amount      = $worker_data ? $worker_data['amount'] : 0;

                                                if ($amount > 0):
                                                    echo '<strong>' . number_format($amount, 0) . ' UGX</strong>';

                                                    if (!empty($worker_data['collaborated_with']) && count($worker_data['collaborated_with']) > 0):
                                                        echo '<br><small style="color: #28a745; font-weight: 500;">';
                                                        echo 'Collaborated with: ' . implode(', ', array_map('htmlspecialchars', $worker_data['collaborated_with']));
                                                        echo '</small>';
                                                    endif;
                                                else:
                                                    echo '---';
                                                endif;
                                                ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="<?= count($display_workers) + 1 ?>" class="text-center">
                                            <div class="alert alert-info mb-0">
                                                No paid entries found for the selected period
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                            <!-- Totals Footer -->
                            <tbody class="tfooter">

                                <!-- General Total - visible to ALL roles -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #e8e8e8;">
                                        <span class="services-td" style="font-weight: bold;">GENERAL TOTAL</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #e8e8e8; font-weight: bold;">
                                            <?php
                                            // For workers, calculate total only from their filtered rows
                                            if($is_worker) {
                                                $worker_total = 0;
                                                foreach($matrix as $row) {
                                                    $wd = isset($row['workers'][$worker->ID]) ? $row['workers'][$worker->ID] : null;
                                                    if($wd) $worker_total += $wd['amount'];
                                                }
                                                echo $worker_total > 0 ? number_format($worker_total, 0) . ' UGX' : '---';
                                            } else {
                                                $t = $totals[$worker->ID]['total'];
                                                echo $t > 0 ? number_format($t, 0) . ' UGX' : '---';
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <?php if(!$is_worker): ?>

                                <!-- 40% Worker Share -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #d4edda;">
                                        <span class="services-td" style="font-weight: bold;">TOTAL 40% (WORKER)</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #d4edda; font-weight: bold; color: #155724;">
                                            <?php
                                            $w40 = $totals[$worker->ID]['worker_40_percent'];
                                            echo $w40 > 0 ? number_format($w40, 0) . ' UGX' : '---';
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <!-- Liquidated – Paid -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #fff3cd;">
                                        <span class="services-td" style="font-weight: bold;">LIQUIDATED (PAID)</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #fff3cd; font-weight: bold; color: #856404;">
                                            <?php
                                            $pl = $totals[$worker->ID]['paid_liquidations'];
                                            echo $pl > 0 ? '- ' . number_format($pl, 0) . ' UGX' : '---';
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <!-- Liquidated – Pending -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #ffe5cc;">
                                        <span class="services-td" style="font-weight: bold;">LIQUIDATED (PENDING)</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #ffe5cc; font-weight: bold; color: #cc5200;">
                                            <?php
                                            $pel = $totals[$worker->ID]['pending_liquidations'];
                                            echo $pel > 0 ? '- ' . number_format($pel, 0) . ' UGX' : '---';
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <!-- Available Balance -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #d1ecf1;">
                                        <span class="services-td" style="font-weight: bold;">AVAILABLE BALANCE</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #d1ecf1; font-weight: bold; color: #0c5460;">
                                            <?= number_format($totals[$worker->ID]['available_balance'], 0) . ' UGX' ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <!-- 60% Company Share -->
                                <tr class="group-row">
                                    <td class="totals" style="background: #cce5ff;">
                                        <span class="services-td" style="font-weight: bold;">TOTAL 60% (COMPANY)</span>
                                    </td>
                                    <?php foreach ($display_workers as $worker): ?>
                                        <td style="background: #cce5ff; font-weight: bold; color: #004085;">
                                            <?php
                                            $c60 = $totals[$worker->ID]['company_60_percent'];
                                            echo $c60 > 0 ? number_format($c60, 0) . ' UGX' : '---';
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>

                                <?php endif; // end non-worker footer rows ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        <i class="mdi mdi-information"></i> No data found. Please add workers first.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<style>
.table-wrapper {
    overflow-x: auto;
}

.services-td {
    display: inline-block;
    min-width: 150px;
}

.totals {
    font-weight: bold;
    font-size: 14px;
}

.tfooter tr td {
    padding: 12px 8px;
}

#table-head th {
    position: sticky;
    top: 0;
    z-index: 10;
    white-space: nowrap;
}

.group-row td {
    vertical-align: middle;
}
</style>

<!-- end row -->