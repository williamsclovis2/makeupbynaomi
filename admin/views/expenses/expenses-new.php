<!-- start page title -->
<div class="page-title-box">
   <div class="row align-items-center">
      <div class="col-md-8">
         <h6 class="page-title">New Expense</h6>
      </div>
      <div class="col-md-4">
         <div class="float-end d-none d-md-block">
            <a class="btn btn-secondary" href="<?=DNADMIN?>/app/expenses/list">
               <i class="mdi mdi-arrow-left me-2"></i> Back to List
            </a>
         </div>
      </div>
   </div>
</div>
<!-- end page title -->

<?php
global $session_user_data, $session_user_ID;

if(!isset($session_user_data)) {
    echo "<div class='alert alert-danger'>Session error. Please <a href='".DNADMIN."/logout'>logout</a> and login again.</div>";
    die();
}

$db = DB::getInstance();
$workers_query = $db->query("SELECT ID, firstname, lastname, groups, state FROM app_users WHERE groups IN ('Worker','Admin','Sub-Admin') AND state IN ('active','Activated') ORDER BY firstname ASC");

$all_workers = $workers_query->results();
?>

<div class="row">
   <div class="col-8">
      <div class="card">
         <div class="card-body">
            <h4 class="card-title mb-4">Create New Expense</h4>

            <!-- ⚠️ Expense Type Guide -->
            <div class="alert alert-warning mb-4">
               <h5 class="mb-3">⚠️ Expense Type Guide</h5>

               <div class="row">
                  <div class="col-md-6">
                     <p class="mb-2">
                        <strong>📦 EXTERNAL EXPENSES</strong> &amp; <strong>💄 SALON SUPPLY</strong><br>
                        <span class="text-muted">Concern the salon as a business.</span><br>
                        Examples: Rent, Marketing, Nail Polish, Gel Materials, Acetone, Lamps, Electricity, Internet.
                     </p>
                     <div class="badge bg-primary text-white px-2 py-1">
                        <i class="mdi mdi-check-circle"></i> Auto-marked as <strong>PAID</strong> when created
                     </div>
                  </div>
                  <div class="col-md-6">
                     <p class="mb-2">
                        <strong>🏢 INTERNAL EXPENSES</strong><br>
                        <span class="text-muted">Concern workers — money given to or requested by a worker.</span><br>
                        Examples: Staff Advance, Bonus, Transport Refund, Equipment Repair.
                     </p>
                     <div class="badge bg-warning text-dark px-2 py-1">
                        <i class="mdi mdi-clock-outline"></i> Starts as <strong>PENDING</strong> — can be liquidated<br> (deducted from earnings)
                     </div>
                  </div>
               </div>

               <hr class="my-3">

               <p class="mb-0 small">
                  <strong>Note:</strong>
                  For salon-wide costs (rent, supplies, utilities) → select <strong>"Barclay Nails Salon"</strong> + External or Salon Supply.<br>
                  For worker money requests (advance, bonus) → select the <strong>worker's name</strong> + Internal.
               </p>
            </div>

            <form method="POST" action="">
               <input type="hidden" name="request"  value="expense-new">
               <input type="hidden" name="webToken" value="<?= Config::get('time/seconds'); ?>">

               <!-- Worker / Entity -->
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label class="form-label">Select Worker / Entity <span class="text-danger">*</span></label>
                     <select class="form-select" id="worker_select" name="expense-worker_id" required>
                        <option value="">[ -- select worker or entity -- ]</option>
                        <option value="salon" style="background-color:#fff3cd; font-weight:bold;">🏪 Barclay Nails Salon (Salon Expenses)</option>
                        <option disabled>──────────────────────────</option>
                        <optgroup label="Workers">
                           <?php foreach($all_workers as $worker): ?>
                              <option value="<?= $worker->ID ?>">
                                 <?= htmlspecialchars($worker->firstname . ' ' . $worker->lastname) ?>
                              </option>
                           <?php endforeach; ?>
                        </optgroup>
                     </select>
                     <small class="text-muted">Select "Barclay Nails Salon" for salon-wide expenses, or a worker for personal/internal expenses</small>
                  </div>
               </div>

               <!-- Expense Type & Category -->
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Expense Type <span class="text-danger">*</span></label>
                     <select class="form-select" id="expense_type" name="expense-expense_type" required>
                        <option value="">[ -- select type -- ]</option>
                        <option value="external">📦 External — Salon Business Cost (auto-paid)</option>
                        <option value="salon_supply">💄 Salon Supply — Materials &amp; Tools (auto-paid)</option>
                        <option value="internal">🏢 Internal — Worker Request (pending, can liquidate)</option>
                     </select>
                     <!-- Type status hint shown dynamically -->
                     <div id="type_hint" class="mt-1"></div>
                  </div>

                  <div class="col-md-6 mb-3">
                     <label class="form-label">Category / Item <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="expense-category"
                            placeholder="e.g., Nail Polish, Staff Advance, Rent" required>
                     <small class="text-muted">What specific item or service was this expense for?</small>
                  </div>
               </div>

               <!-- Amount -->
               <div class="row">
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Amount (UGX) <span class="text-danger">*</span></label>
                     <input type="number" step="0.01" class="form-control" id="amount"
                            name="expense-amount" placeholder="Enter amount" required min="1">
                  </div>
                  <div class="col-md-6 mb-3">
                     <label class="form-label">Amount Display</label>
                     <input type="text" class="form-control" id="amount_display" readonly
                            style="background-color:#e9ecef; font-weight:bold; color:#2c5cc5;">
                     <small class="text-muted">Formatted amount for confirmation</small>
                  </div>
               </div>

               <!-- Reason -->
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label class="form-label">Reason <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="expense-reason"
                            placeholder="Short reason for this expense" required>
                     <small class="text-muted">Brief explanation (e.g., "Monthly rent payment", "Emergency advance")</small>
                  </div>
               </div>

               <!-- Description -->
               <div class="row">
                  <div class="col-md-12 mb-3">
                     <label class="form-label">Description (Optional)</label>
                     <textarea class="form-control" rows="3" name="expense-description"
                               placeholder="Additional details about this expense (optional)..."></textarea>
                  </div>
               </div>

               <!-- Buttons -->
               <div class="row">
                  <div class="col-12">
                     <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Save Expense
                     </button>
                     <button type="reset" class="btn btn-secondary" onclick="document.getElementById('amount_display').value='';">
                        <i class="mdi mdi-refresh"></i> Reset Form
                     </button>
                     <a href="<?=DNADMIN?>/app/expenses/list" class="btn btn-outline-secondary">
                        <i class="mdi mdi-cancel"></i> Cancel
                     </a>
                  </div>
               </div>
            </form>

         </div>
      </div>
   </div>

   <!-- Quick Reference -->
   <div class="col-4">
      <div class="card">
         <div class="card-body">
            <h4 class="card-title mb-3">Quick Reference</h4>

            <div class="mb-3 p-2 rounded" style="background:#e8f4fd;">
               <h6 class="text-primary mb-1">📦 External</h6>
               <p class="small mb-1">Rent, Marketing, Insurance, Taxes, Legal Fees, Equipment Purchase, Maintenance</p>
               <span class="badge bg-primary">Auto-Paid on Save</span>
            </div>

            <div class="mb-3 p-2 rounded" style="background:#e8f8f0;">
               <h6 class="text-success mb-1">💄 Salon Supply</h6>
               <p class="small mb-1">Nail Polish, Gel, Acrylic, Acetone, Files, Tools, Sanitization, Towels, Brushes, Lamps</p>
               <span class="badge bg-primary">Auto-Paid on Save</span>
            </div>

            <div class="mb-3 p-2 rounded" style="background:#fff8e1;">
               <h6 class="text-warning mb-1">🏢 Internal</h6>
               <p class="small mb-1">Staff Advance, Bonus, Transport Refund, Repair, Food, Office Supplies</p>
               <span class="badge bg-warning text-dark">Starts Pending → Liquidate to deduct from worker</span>
            </div>

            <hr>
            <div class="alert alert-info small mb-0">
               <strong>💡 Tip:</strong> External &amp; Salon Supply expenses are recorded as
               <strong>Paid</strong> immediately. Internal worker expenses stay
               <strong>Pending</strong> until you convert them to a liquidation.
            </div>
         </div>
      </div>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const amountInput   = document.getElementById('amount');
    const amountDisplay = document.getElementById('amount_display');
    const workerSelect  = document.getElementById('worker_select');
    const expenseType   = document.getElementById('expense_type');
    const typeHint      = document.getElementById('type_hint');

    // All options with their data
    const optionDefs = [
        { value: 'external',     label: '📦 External — Salon Business Cost (auto-paid)',                   group: 'salon'  },
        { value: 'salon_supply', label: '💄 Salon Supply — Materials & Tools (auto-paid)',                 group: 'salon'  },
        { value: 'internal',     label: '🏢 Internal — Worker Request (pending, can liquidate)',           group: 'worker' },
    ];

    function rebuildTypeOptions(group) {
        // Save current value to restore if still valid
        const current = expenseType.value;

        // Clear all options except placeholder
        expenseType.innerHTML = '<option value="">[ -- select type -- ]</option>';

        optionDefs
            .filter(opt => !group || opt.group === group)
            .forEach(opt => {
                const el = document.createElement('option');
                el.value = opt.value;
                el.textContent = opt.label;
                if (opt.value === current) el.selected = true;
                expenseType.appendChild(el);
            });

        // If only one option available, auto-select it
        const available = optionDefs.filter(opt => !group || opt.group === group);
        if (available.length === 1) {
            expenseType.value = available[0].value;
        }

        // Trigger hint update
        expenseType.dispatchEvent(new Event('change'));
    }

    // Filter type options when worker/salon is selected
    workerSelect.addEventListener('change', function () {
        if (this.value === '') {
            // Nothing selected — show all
            rebuildTypeOptions(null);
        } else if (this.value === 'salon') {
            // Salon selected — show only external + salon_supply
            rebuildTypeOptions('salon');
        } else {
            // Worker selected — show only internal
            rebuildTypeOptions('worker');
        }
    });

    // Show status hint based on type selected
    expenseType.addEventListener('change', function () {
        const val = this.value;
        if (val === 'external' || val === 'salon_supply') {
            typeHint.innerHTML = '<span class="badge bg-primary px-2 py-1"><i class="mdi mdi-check-circle"></i> This expense will be automatically marked as <strong>PAID</strong> when saved.</span>';
        } else if (val === 'internal') {
            typeHint.innerHTML = '<span class="badge bg-warning text-dark px-2 py-1"><i class="mdi mdi-clock-outline"></i> This expense will start as <strong>PENDING</strong>. Convert to liquidation<br> later to deduct from the worker\'s earnings.</span>';
        } else {
            typeHint.innerHTML = '';
        }
    });

    // Format amount as user types
    amountInput.addEventListener('input', function () {
        const value = parseFloat(this.value);
        amountDisplay.value = (!isNaN(value) && value > 0)
            ? value.toLocaleString('en-UG') + ' UGX'
            : '';
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function (e) {
        const amount = parseFloat(amountInput.value);
        if (isNaN(amount) || amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount greater than 0');
            amountInput.focus();
        }
    });
});
</script>