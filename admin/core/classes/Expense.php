<?php

/**
 * Expense Model Class
 * Handles all expense-related database operations
 */
class Expense {
    
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
    }

    /**
     * Insert new expense
     */
    public function insert($fields = array()) {
        if (!$this->_db->insert('expenses', $fields)) {
            throw new Exception('Failed to create expense.');
        }
        return $this->_db->lastInsertId();
    }

    /**
     * Update expense
     */
    public function update($fields = array(), $id = null) {
        if (!$id && $this->data()->id) {
            $id = $this->data()->id;
        }
        if (!$this->_db->update('expenses', $id, $fields)) {
            throw new Exception('Failed to update expense.');
        }
    }

    /**
     * Find expense by ID
     */
    public function find($expense_id = null) {
        if ($expense_id) {
            $data = $this->_db->query("SELECT * FROM `expenses` WHERE `id` = ?", array($expense_id));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    /**
     * Get all expenses with optional filters
     */
    public function getAllExpenses($filters = array()) {
        $sql = "SELECT * FROM expenses WHERE 1=1";
        $params = array();

        // Filter by user
        if (isset($filters['user_id']) && !empty($filters['user_id'])) {
            $sql .= " AND user_id = ?";
            $params[] = $filters['user_id'];
        }

        // Filter by expense type
        if (isset($filters['expense_type']) && !empty($filters['expense_type'])) {
            $sql .= " AND expense_type = ?";
            $params[] = $filters['expense_type'];
        }

        // Filter by status
        if (isset($filters['status']) && !empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        // Filter by date range
        if (isset($filters['from_date']) && !empty($filters['from_date'])) {
            $sql .= " AND created_date >= ?";
            $params[] = $filters['from_date'];
        }

        if (isset($filters['to_date']) && !empty($filters['to_date'])) {
            $sql .= " AND created_date <= ?";
            $params[] = $filters['to_date'];
        }

        // Filter by keyword (search in user_name, category, reason)
        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $sql .= " AND (user_name LIKE ? OR category LIKE ? OR reason LIKE ?)";
            $keyword = '%' . $filters['keyword'] . '%';
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        // Order by date
        $sql .= " ORDER BY created_date DESC, created_time DESC";

        $result = $this->_db->query($sql, $params);
        return $result->results();
    }

    /**
     * Get total expenses for a user
     */
    public function getTotalExpensesForUser($user_id, $status = null) {
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE user_id = ?";
        $params = array($user_id);

        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $result = $this->_db->query($sql, $params);
        if ($result->count()) {
            return $result->first()->total ?? 0;
        }
        return 0;
    }

    /**
     * Get total expenses by type
     */
    public function getTotalByType($expense_type, $from_date = null, $to_date = null) {
        $sql = "SELECT SUM(amount) as total FROM expenses WHERE expense_type = ?";
        $params = array($expense_type);

        if ($from_date) {
            $sql .= " AND created_date >= ?";
            $params[] = $from_date;
        }

        if ($to_date) {
            $sql .= " AND created_date <= ?";
            $params[] = $to_date;
        }

        $result = $this->_db->query($sql, $params);
        if ($result->count()) {
            return $result->first()->total ?? 0;
        }
        return 0;
    }

    /**
     * Get user's pending and waiting expenses total
     */
    public function getUserPendingTotal($user_id) {
        $sql = "SELECT SUM(amount) as total FROM expenses 
                WHERE user_id = ? AND status IN ('pending', 'waiting')";
        $result = $this->_db->query($sql, array($user_id));
        if ($result->count()) {
            return $result->first()->total ?? 0;
        }
        return 0;
    }

    /**
     * Get user's liquidated expenses total
     */
    public function getUserLiquidatedTotal($user_id) {
        $sql = "SELECT SUM(amount) as total FROM expenses 
                WHERE user_id = ? AND status = 'liquidated'";
        $result = $this->_db->query($sql, array($user_id));
        if ($result->count()) {
            return $result->first()->total ?? 0;
        }
        return 0;
    }

    /**
     * Get expense statistics for dashboard
     */
    public function getExpenseStats($from_date = null, $to_date = null) {
        $sql = "SELECT 
                    COUNT(*) as total_count,
                    SUM(amount) as total_amount,
                    SUM(CASE WHEN expense_type = 'salon_supply' THEN amount ELSE 0 END) as salon_supply_total,
                    SUM(CASE WHEN expense_type = 'internal' THEN amount ELSE 0 END) as internal_total,
                    SUM(CASE WHEN expense_type = 'external' THEN amount ELSE 0 END) as external_total,
                    SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as pending_total,
                    SUM(CASE WHEN status = 'waiting' THEN amount ELSE 0 END) as waiting_total,
                    SUM(CASE WHEN status = 'liquidated' THEN amount ELSE 0 END) as liquidated_total
                FROM expenses WHERE 1=1";
        
        $params = array();

        if ($from_date) {
            $sql .= " AND created_date >= ?";
            $params[] = $from_date;
        }

        if ($to_date) {
            $sql .= " AND created_date <= ?";
            $params[] = $to_date;
        }

        $result = $this->_db->query($sql, $params);
        if ($result->count()) {
            return $result->first();
        }
        return null;
    }

    /**
     * Convert expense to liquidation
     */
    public function convertToLiquidation($expense_id, $liquidation_id) {
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        $this->update(array(
            'status' => 'liquidated',
            'liquidation_id' => $liquidation_id,
            'liquidated_date' => $current_date,
            'liquidated_time' => $current_time,
            'updated_date' => $current_date,
            'updated_time' => $current_time
        ), $expense_id);
    }

    /**
     * Delete expense
     */
    public function delete($expense_id) {
        $query = $this->_db->query("DELETE FROM `expenses` WHERE `id` = ?", array($expense_id));
        return $query ? true : false;
    }

    /**
     * Get data
     */
    public function data() {
        return $this->_data;
    }

    /**
     * Check if expense exists
     */
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }
}

?>