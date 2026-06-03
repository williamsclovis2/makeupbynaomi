<?php

class Liquidation {

    private $_db,
            $_data,
            $_count = 0,
            $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // CREATE LIQUIDATION
    public function insert($fields = array()) {
        if (!$this->_db->insert('liquidations', $fields)) {
            throw new Exception("There was a problem creating the liquidation.");
        }
        return $this->_db->lastInsertId();
    }

    // UPDATE LIQUIDATION
    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('liquidations', $id, $fields)) {
            throw new Exception('There was a problem updating the liquidation.');
        }
    }

    // FIND LIQUIDATION
    public function find($liquidation_id = null) {
        if ($liquidation_id) {
            $data = $this->_db->query(
                "SELECT * FROM `liquidations` WHERE `id` = ?",
                array($liquidation_id)
            );
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // GET ALL LIQUIDATIONS
    public function getAllLiquidations($filters = array()) {
        $sql    = "SELECT * FROM liquidations WHERE 1=1";
        $params = array();

        if (isset($filters['user_id']) && !empty($filters['user_id'])) {
            $sql      .= " AND user_id = ?";
            $params[]  = $filters['user_id'];
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $sql      .= " AND status = ?";
            $params[]  = $filters['status'];
        }

        if (isset($filters['from_date']) && !empty($filters['from_date'])) {
            $sql      .= " AND created_date >= ?";
            $params[]  = $filters['from_date'];
        }

        if (isset($filters['to_date']) && !empty($filters['to_date'])) {
            $sql      .= " AND created_date <= ?";
            $params[]  = $filters['to_date'];
        }

        $sql .= " ORDER BY created_date DESC, created_time DESC";

        $data = $this->_db->query($sql, $params);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data  = $data->results();
            return $this->_data;
        }
        return array();
    }

    /**
     * Get total liquidated amount for a user.
     * Optionally scope to a date range using liquidation_date.
     *
     * @param  int         $user_id
     * @param  string      $status      'paid' | 'pending' | 'cancelled'
     * @param  string|null $week_start  Y-m-d
     * @param  string|null $week_end    Y-m-d
     * @return float
     */
    public function getTotalLiquidatedForUser($user_id, $status = 'paid', $week_start = null, $week_end = null) {
        try {
            if ($week_start && $week_end) {
                $query = $this->_db->query("
                    SELECT COALESCE(SUM(amount_liquidated), 0) AS total
                    FROM   liquidations
                    WHERE  user_id          = ?
                      AND  status           = ?
                      AND  liquidation_date >= ?
                      AND  liquidation_date <= ?
                ", array($user_id, $status, $week_start, $week_end));
            } else {
                $query = $this->_db->query("
                    SELECT COALESCE(SUM(amount_liquidated), 0) AS total
                    FROM   liquidations
                    WHERE  user_id = ?
                      AND  status  = ?
                ", array($user_id, $status));
            }

            return (float) ($query->first()->total ?? 0);

        } catch (Exception $e) {
            return 0.0;
        }
    }

    /**
     * Get total PENDING liquidations for a user.
     * When week_start + week_end are supplied, only pending liquidations
     * whose liquidation_date falls inside that range are counted.
     *
     * This prevents last week's unresolved pending liquidations from
     * eating into the new week's available balance after Sunday reset.
     *
     * @param  int         $user_id
     * @param  string|null $week_start  Y-m-d
     * @param  string|null $week_end    Y-m-d
     * @return float
     */
    public function getPendingLiquidationsForUser($user_id, $week_start = null, $week_end = null) {
        try {
            if ($week_start && $week_end) {
                $query = $this->_db->query("
                    SELECT COALESCE(SUM(amount_liquidated), 0) AS total
                    FROM   liquidations
                    WHERE  user_id          = ?
                      AND  status           = 'pending'
                      AND  liquidation_date >= ?
                      AND  liquidation_date <= ?
                ", array($user_id, $week_start, $week_end));
            } else {
                $query = $this->_db->query("
                    SELECT COALESCE(SUM(amount_liquidated), 0) AS total
                    FROM   liquidations
                    WHERE  user_id = ?
                      AND  status  = 'pending'
                ", array($user_id));
            }

            return (float) ($query->first()->total ?? 0);

        } catch (Exception $e) {
            return 0.0;
        }
    }

    // DATA COLLECT
    public function data() {
        return $this->_data;
    }

    // COUNT
    public function count() {
        return $this->_count;
    }

    // ERRORS
    public function errors() {
        return $this->_errors;
    }
}

?>