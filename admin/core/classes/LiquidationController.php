<?php

class LiquidationController {

    /**
     * Calculates a worker's available balance for the CURRENT WEEK only.
     *
     * Formula:
     *   available = (week_earnings × 40%)
     *             − paid_liquidations     (scoped to this week)
     *             − pending_liquidations  (scoped to this week)
     *             − pending_expenses      (scoped to this week)
     *
     * Week cycle: Sunday 00:00:00 → Saturday 23:59:59
     * After Saturday, everything resets automatically on Sunday.
     *
     * @param  int        $worker_id
     * @param  float|null $exclude_expense_amount  Pass current expense amount
     *                    when calling from convertToLiquidation() to avoid
     *                    double-counting.
     * @return array
     */
    public static function getWorkerAvailableAmountWeekScoped($worker_id, $exclude_expense_amount = 0) {
        $db               = DB::getInstance();
        $liquidationClass = new Liquidation();
        $expenseClass     = new Expense();

        // ── Current week range (mirrors DashboardController) ────────────
        $week       = DashboardController::getCurrentWeekRange();
        $week_start = $week['week_start'];
        $week_end   = $week['week_end'];

        // ── Week-scoped solo earnings (paid entries only) ────────────────
        $soloQuery = $db->query("
            SELECT COALESCE(SUM(user_final_amount), 0) AS total
            FROM   entries
            WHERE  user_id      = ?
              AND  status       = 'paid'
              AND  created_date >= ?
              AND  created_date <= ?
        ", array($worker_id, $week_start, $week_end));
        $solo_total = (float) ($soloQuery->first()->total ?? 0);

        // ── Week-scoped collaboration earnings (paid entries only) ───────
        $collabQuery = $db->query("
            SELECT COALESCE(SUM(ec.amount), 0) AS total
            FROM   entry_collaborators ec
            INNER  JOIN entries e ON e.id = ec.entry_id
            WHERE  ec.user_id     = ?
              AND  e.status       = 'paid'
              AND  e.created_date >= ?
              AND  e.created_date <= ?
        ", array($worker_id, $week_start, $week_end));
        $collab_total = (float) ($collabQuery->first()->total ?? 0);

        // Worker takes home 40% of total billed this week
        $total_earnings = ($solo_total + $collab_total) * 0.40;

        // ── Paid liquidations — scoped to this week ──────────────────────
        $paid_liquidations = $liquidationClass->getTotalLiquidatedForUser(
            $worker_id, 'paid', $week_start, $week_end
        );

        // ── Pending liquidations — scoped to this week ───────────────────
        // OLD: no date scope — last week's pending bled into new week ❌
        // NEW: week-scoped — Sunday reset works correctly              ✅
        $pending_liquidations = $liquidationClass->getPendingLiquidationsForUser(
            $worker_id, $week_start, $week_end
        );

        // ── Pending expenses — scoped to this week ───────────────────────
        $pending_expenses = max(0,
            (float) $expenseClass->getUserPendingTotal($worker_id, $week_start, $week_end)
            - (float) $exclude_expense_amount
        );

        // ── Final available amount ───────────────────────────────────────
        $available = $total_earnings
                     - $paid_liquidations
                     - $pending_liquidations
                     - $pending_expenses;

        return array(
            'week_start'           => $week_start,
            'week_end'             => $week_end,
            'week_label'           => $week['label'],
            'total_earnings'       => $total_earnings,
            'paid_liquidations'    => $paid_liquidations,
            'pending_liquidations' => $pending_liquidations,
            'pending_expenses'     => $pending_expenses,
            'available'            => max(0, $available),
        );
    }

    /**
     * Create a new liquidation.
     * Uses week-scoped calculation to match the dashboard exactly.
     */
    public static function create() {
        global $session_user_ID;

        if (!isset($session_user_ID) || empty($session_user_ID)) {
            throw new Exception("User session not found. Please login again.");
        }

        $diagnoArray[0] = 'NO_ERRORS';
        $validate       = new Validate();

        $validation = $validate->check($_POST, array(
            'worker_id' => array(
                'name'     => 'Worker',
                'required' => true
            ),
            'liquidation_amount' => array(
                'name'     => 'Liquidation Amount',
                'required' => true,
                'min'      => 1
            ),
            'payment_method' => array(
                'name'     => 'Payment Method',
                'required' => true
            ),
            'liquidation_date' => array(
                'name'     => 'Liquidation Date',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            try {
                $db               = DB::getInstance();
                $liquidationClass = new Liquidation();

                $worker_id          = $_POST['worker_id'];
                $liquidation_amount = (float) $_POST['liquidation_amount'];
                $payment_method     = $_POST['payment_method'];
                $liquidation_date   = $_POST['liquidation_date'];
                $description        = isset($_POST['description']) ? $_POST['description'] : '';

                // Get worker name
                $workerQuery = $db->query(
                    "SELECT firstname, lastname FROM app_users WHERE ID = ?",
                    array($worker_id)
                );
                if (!$workerQuery->count()) {
                    throw new Exception("Worker not found.");
                }
                $worker_data = $workerQuery->first();
                $worker_name = $worker_data->firstname . ' ' . $worker_data->lastname;

                // ── Week-scoped balance check ────────────────────────────
                $balance = self::getWorkerAvailableAmountWeekScoped($worker_id);

                if ($liquidation_amount > $balance['available']) {
                    throw new Exception(
                        "Liquidation amount (" . number_format($liquidation_amount, 0) . " UGX) "
                        . "exceeds available amount (" . number_format($balance['available'], 0) . " UGX) "
                        . "for week " . $balance['week_label']
                    );
                }

                $liquidationClass->insert(array(
                    'user_id'           => $worker_id,
                    'user_name'         => $worker_name,
                    'total_earnings'    => $balance['total_earnings'],
                    'amount_liquidated' => $liquidation_amount,
                    'payment_method'    => $payment_method,
                    'liquidation_date'  => $liquidation_date,
                    'description'       => $description,
                    'status'            => 'pending',
                    'created_by'        => $session_user_ID,
                    'created_date'      => date('Y-m-d'),
                    'created_time'      => date('H:i:s')
                ));

                Session::put(
                    'success',
                    'Liquidation created successfully! Amount: '
                    . number_format($liquidation_amount, 0) . ' UGX is pending approval.'
                );

            } catch (Exception $e) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[]  = $e->getMessage();
            }
        } else {
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        }

        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => $diagnoArray
            ];
        }

        return (object) [
            'ERRORS'        => false,
            'SUCCESS'       => true,
            'ERRORS_SCRIPT' => ""
        ];
    }

    /**
     * Change liquidation status (pending → paid / cancelled)
     */
    public static function changeStatus($status, $liquidation_id) {
        try {
            $liquidationClass = new Liquidation();

            if (!$liquidationClass->find($liquidation_id)) {
                throw new Exception("Liquidation not found");
            }

            $valid_statuses = ['pending', 'paid', 'cancelled'];
            if (!in_array($status, $valid_statuses)) {
                throw new Exception("Invalid status");
            }

            $liquidationClass->update(array(
                'status'       => $status,
                'updated_date' => date('Y-m-d'),
                'updated_time' => date('H:i:s')
            ), $liquidation_id);

            $messages = [
                'paid'      => 'Liquidation marked as PAID! Amount deducted from worker earnings.',
                'cancelled' => 'Liquidation cancelled. Amount returned to available earnings.',
                'pending'   => 'Liquidation status changed to pending.'
            ];

            Session::put('success', $messages[$status]);

            return (object) ['ERRORS' => false, 'SUCCESS' => true];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => $e->getMessage()
            ];
        }
    }

    /**
     * Get all liquidations with optional filters
     */
    public static function getAllLiquidations($filters = array()) {
        try {
            $liquidationClass = new Liquidation();
            return $liquidationClass->getAllLiquidations($filters);
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get worker's available amount — week-scoped to match dashboard.
     * Public proxy used wherever the UI needs to display the balance.
     */
    public static function getWorkerAvailableAmount($worker_id) {
        return self::getWorkerAvailableAmountWeekScoped($worker_id);
    }
}