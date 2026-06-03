<?php

/**
 * Expense Controller
 * Handles all expense-related operations and business logic
 *
 * BUSINESS LOGIC:
 * - External expenses  → concern the SALON (rent, marketing, etc.)
 *                        Auto-set to 'liquidated' on creation. No worker deduction needed.
 * - Internal expenses  → concern WORKERS (advances, bonuses, etc.)
 *                        Start as 'pending', can be converted to liquidation (deducted from earnings).
 * - Salon Supply       → treated same as External (salon-wide, auto-liquidated on creation).
 */
class ExpenseController {

    /**
     * Create a new expense
     */
    public static function create() {
        // Read session directly — avoids global variable issues on live servers
        $session_user_ID = Session::get('storiafrica_ID');
        if (empty($session_user_ID)) {
            throw new Exception("User session not found. Please login again.");
        }

        $diagnoArray    = array();
        $diagnoArray[0] = 'NO_ERRORS';
        $validate       = new Validate();
        $prfx           = 'expense-';

        // Strictly parse only keys that start with 'expense-'
        $_EXPENSE = array();
        foreach ($_POST as $index => $val) {
            if (strpos($index, $prfx) === 0) {
                $key            = substr($index, strlen($prfx));
                $_EXPENSE[$key] = $val;
            }
        }

        if (empty($_EXPENSE)) {
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => array('ERRORS_FOUND', 'Form data not received. Please try again.')
            ];
        }

        // Validate input
        $validation = $validate->check($_EXPENSE, array(
            'worker_id' => array(
                'name'     => 'Worker',
                'required' => true
            ),
            'expense_type' => array(
                'name'     => 'Expense Type',
                'required' => true
            ),
            'category' => array(
                'name'     => 'Category',
                'required' => true
            ),
            'amount' => array(
                'name'     => 'Amount',
                'required' => true,
                'min'      => 1
            ),
            'reason' => array(
                'name'     => 'Reason',
                'required' => true,
                'min'      => 5
            )
        ));

        if ($validation->passed()) {
            try {
                $db           = DB::getInstance();
                $expenseClass = new Expense();

                $worker_id    = $_EXPENSE['worker_id'];
                $expense_type = $_EXPENSE['expense_type'];
                $category     = $_EXPENSE['category'];
                $amount       = $_EXPENSE['amount'];
                $reason       = $_EXPENSE['reason'];
                $description  = isset($_EXPENSE['description']) ? $_EXPENSE['description'] : '';

                // Determine user_name
                if ($worker_id == 'salon') {
                    $user_name = 'Barclay Nails Salon';
                    $worker_id = NULL;
                } else {
                    $workerQuery = $db->query(
                        "SELECT firstname, lastname FROM app_users WHERE ID = ?",
                        array($worker_id)
                    );
                    if ($workerQuery->count()) {
                        $worker_data = $workerQuery->first();
                        $user_name   = $worker_data->firstname . ' ' . $worker_data->lastname;
                    } else {
                        throw new Exception("Worker not found.");
                    }
                }

                // Determine initial status:
                // External expenses and Salon Supply are salon-wide → auto liquidated (paid immediately)
                // Internal expenses are worker-related → start as pending
                $is_salon_expense = ($expense_type === 'external' || $expense_type === 'salon_supply');
                $initial_status   = $is_salon_expense ? 'liquidated' : 'pending';

                $current_date = date('Y-m-d');
                $current_time = date('H:i:s');

                $insert_fields = array(
                    'user_id'      => $worker_id,
                    'user_name'    => $user_name,
                    'expense_type' => $expense_type,
                    'category'     => $category,
                    'amount'       => $amount,
                    'reason'       => $reason,
                    'description'  => $description,
                    'status'       => $initial_status,
                    'created_by'   => $session_user_ID,
                    'created_date' => $current_date,
                    'created_time' => $current_time
                );

                // For auto-liquidated salon expenses, set liquidated timestamps immediately
                if ($is_salon_expense) {
                    $insert_fields['liquidated_date'] = $current_date;
                    $insert_fields['liquidated_time'] = $current_time;
                }

                $expense_id = $expenseClass->insert($insert_fields);

                $formatted_amount = number_format($amount, 0);

                if ($is_salon_expense) {
                    Session::put('success', "Salon expense recorded and marked as paid! Amount: {$formatted_amount} UGX for {$category}");
                } else {
                    Session::put('success', "Worker expense created successfully! Amount: {$formatted_amount} UGX for {$user_name} — pending liquidation.");
                }

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
     * Update an existing expense
     */
    public static function update($expense_id) {
        // Read session directly — avoids global variable issues on live servers
        $session_user_ID = Session::get('storiafrica_ID');
        if (empty($session_user_ID)) {
            throw new Exception("User session not found. Please login again.");
        }

        $diagnoArray    = array();
        $diagnoArray[0] = 'NO_ERRORS';
        $validate       = new Validate();
        $prfx           = 'expense-';

        // Strictly parse only keys that start with 'expense-'
        $_EXPENSE = array();
        foreach ($_POST as $index => $val) {
            if (strpos($index, $prfx) === 0) {
                $key            = substr($index, strlen($prfx));
                $_EXPENSE[$key] = $val;
            }
        }

        if (empty($_EXPENSE)) {
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => array('ERRORS_FOUND', 'Form data not received. Please try again.')
            ];
        }

        $validation = $validate->check($_EXPENSE, array(
            'expense_type' => array('name' => 'Expense Type', 'required' => true),
            'category'     => array('name' => 'Category',     'required' => true),
            'amount'       => array('name' => 'Amount',       'required' => true, 'min' => 1),
            'reason'       => array('name' => 'Reason',       'required' => true, 'min' => 5)
        ));

        if ($validation->passed()) {
            try {
                $expenseClass = new Expense();

                if (!$expenseClass->find($expense_id)) {
                    throw new Exception("Expense not found.");
                }

                $existing     = $expenseClass->data();
                $expense_type = $_EXPENSE['expense_type'];
                $category     = $_EXPENSE['category'];
                $amount       = $_EXPENSE['amount'];
                $reason       = $_EXPENSE['reason'];
                $description  = isset($_EXPENSE['description']) ? $_EXPENSE['description'] : '';

                $current_date = date('Y-m-d');
                $current_time = date('H:i:s');

                $is_salon_expense  = ($expense_type === 'external' || $expense_type === 'salon_supply');
                $was_salon_expense = ($existing->expense_type === 'external' || $existing->expense_type === 'salon_supply');

                $update_fields = array(
                    'expense_type' => $expense_type,
                    'category'     => $category,
                    'amount'       => $amount,
                    'reason'       => $reason,
                    'description'  => $description,
                    'updated_date' => $current_date,
                    'updated_time' => $current_time
                );

                // If type changed from internal → external/salon_supply: auto-liquidate
                if ($is_salon_expense && !$was_salon_expense && $existing->status !== 'liquidated') {
                    $update_fields['status']          = 'liquidated';
                    $update_fields['liquidated_date'] = $current_date;
                    $update_fields['liquidated_time'] = $current_time;
                }

                // If type changed from external/salon_supply → internal: reset to pending
                if (!$is_salon_expense && $was_salon_expense && $existing->status === 'liquidated' && empty($existing->liquidation_id)) {
                    $update_fields['status']          = 'pending';
                    $update_fields['liquidated_date'] = NULL;
                    $update_fields['liquidated_time'] = NULL;
                }

                $expenseClass->update($update_fields, $expense_id);

                Session::put('success', 'Expense updated successfully!');

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
     * Change expense status manually (only for internal/worker expenses)
     */
    public static function changeStatus($status, $expense_id) {
        try {
            $expenseClass = new Expense();

            if (!$expenseClass->find($expense_id)) {
                throw new Exception("Expense not found");
            }

            $expense = $expenseClass->data();

            // Prevent manually changing status of salon/external expenses
            $is_salon_expense = ($expense->expense_type === 'external' || $expense->expense_type === 'salon_supply');
            if ($is_salon_expense) {
                throw new Exception("Salon/external expenses are managed automatically and cannot have their status changed manually.");
            }

            $valid_statuses = ['pending', 'waiting', 'liquidated', 'cancelled'];
            if (!in_array($status, $valid_statuses)) {
                throw new Exception("Invalid status");
            }

            $current_date = date('Y-m-d');
            $current_time = date('H:i:s');

            $expenseClass->update(array(
                'status'       => $status,
                'updated_date' => $current_date,
                'updated_time' => $current_time
            ), $expense_id);

            $messages = [
                'pending'    => 'Expense status changed to PENDING.',
                'waiting'    => 'Expense status changed to WAITING.',
                'liquidated' => 'Expense marked as LIQUIDATED!',
                'cancelled'  => 'Expense has been CANCELLED.',
            ];

            Session::put('success', $messages[$status]);

            return (object) ['ERRORS' => false, 'SUCCESS' => true];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true, 'ERRORS_SCRIPT' => $e->getMessage()];
        }
    }

    /**
     * Convert INTERNAL expense to liquidation (deduct from worker earnings)
     */
    public static function convertToLiquidation($expense_id) {
        // Read session directly — avoids global variable issues on live servers
        $session_user_ID = Session::get('storiafrica_ID');
        if (empty($session_user_ID)) {
            throw new Exception("User session not found. Please login again.");
        }

        try {
            $expenseClass     = new Expense();
            $liquidationClass = new Liquidation();

            if (!$expenseClass->find($expense_id)) {
                throw new Exception("Expense not found");
            }

            $expense = $expenseClass->data();

            // Only internal expenses can be liquidated (deducted from worker)
            if ($expense->expense_type === 'external' || $expense->expense_type === 'salon_supply') {
                throw new Exception("Salon/external expenses are already recorded as paid. Only internal worker expenses can be converted to liquidation.");
            }

            if (empty($expense->user_id)) {
                throw new Exception("Cannot convert salon expense to liquidation. Only worker expenses can be liquidated.");
            }

            if ($expense->status == 'liquidated') {
                throw new Exception("This expense has already been liquidated.");
            }

            if ($expense->status == 'cancelled') {
                throw new Exception("Cannot liquidate a cancelled expense.");
            }

            // Use the shared week-scoped helper from LiquidationController
            // to ensure available amount matches the dashboard exactly.
            // Pass the current expense amount to avoid double-counting it
            // in pending_expenses.
            $balance          = LiquidationController::getWorkerAvailableAmountWeekScoped(
                $expense->user_id,
                $expense->amount
            );
            $total_earnings   = $balance['total_earnings'];
            $available_amount = $balance['available'];

            if ($expense->amount > $available_amount) {
                throw new Exception(
                    "Cannot liquidate! Expense amount (" . number_format($expense->amount, 0) . " UGX) " .
                    "exceeds worker's available amount (" . number_format($available_amount, 0) . " UGX)"
                );
            }

            $current_date = date('Y-m-d');
            $current_time = date('H:i:s');

            $liquidation_id = $liquidationClass->insert(array(
                'user_id'           => $expense->user_id,
                'user_name'         => $expense->user_name,
                'total_earnings'    => $total_earnings,
                'amount_liquidated' => $expense->amount,
                'payment_method'    => 'expense_deduction',
                'liquidation_date'  => $current_date,
                'description'       => "Auto-created from Expense: " . $expense->category . " - " . $expense->reason,
                'status'            => 'paid',
                'created_by'        => $session_user_ID,
                'created_date'      => $current_date,
                'created_time'      => $current_time
            ));

            $expenseClass->convertToLiquidation($expense_id, $liquidation_id);

            Session::put('success',
                'Expense successfully converted to liquidation! Amount: ' .
                number_format($expense->amount, 0) . ' UGX deducted from ' . $expense->user_name . "'s earnings."
            );

            return (object) ['ERRORS' => false, 'SUCCESS' => true];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true, 'ERRORS_SCRIPT' => $e->getMessage()];
        }
    }

    /**
     * Delete expense (only non-liquidated)
     */
    public static function delete($expense_id) {
        try {
            $expenseClass = new Expense();

            if (!$expenseClass->find($expense_id)) {
                throw new Exception("Expense not found");
            }

            $expense = $expenseClass->data();

            if ($expense->status == 'liquidated') {
                throw new Exception("Cannot delete a liquidated expense. Please contact administrator.");
            }

            $expenseClass->delete($expense_id);
            Session::put('success', 'Expense deleted successfully!');

            return (object) ['ERRORS' => false, 'SUCCESS' => true];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true, 'ERRORS_SCRIPT' => $e->getMessage()];
        }
    }

    /**
     * Get all expenses with filters
     */
    public static function getAllExpenses($filters = array()) {
        try {
            $expenseClass = new Expense();
            return $expenseClass->getAllExpenses($filters);
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get expense statistics
     */
    public static function getExpenseStats($from_date = null, $to_date = null) {
        try {
            $expenseClass = new Expense();
            return $expenseClass->getExpenseStats($from_date, $to_date);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get worker's total expenses
     */
    public static function getWorkerExpenses($user_id) {
        try {
            $expenseClass = new Expense();
            return array(
                'pending'    => $expenseClass->getUserPendingTotal($user_id),
                'liquidated' => $expenseClass->getUserLiquidatedTotal($user_id),
                'total'      => $expenseClass->getTotalExpensesForUser($user_id)
            );
        } catch (Exception $e) {
            return array('pending' => 0, 'liquidated' => 0, 'total' => 0);
        }
    }
}