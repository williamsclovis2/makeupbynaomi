<?php

class WorkerMatrix {
    private $_db;
    private $_data;
    private $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    /**
     * Get all active workers/users
     */
    public function getAllWorkers() {
        $query = $this->_db->query("
            SELECT ID, firstname, lastname, CONCAT(firstname, ' ', lastname) AS full_name
            FROM   app_users
            WHERE  state = 'activated'
            ORDER  BY firstname ASC
        ");
        return $query->count() ? $query->results() : array();
    }

    /**
     * Get paid entries with optional filters.
     * If $user_id is provided, only return entries where that worker
     * is either the main worker or a collaborator.
     */
    public function getAllPaidEntries($from_date = null, $to_date = null, $user_id = null) {
        if (!empty($user_id)) {
            // Return entries where the chosen worker appears as main worker OR collaborator
            $sql = "
                SELECT DISTINCT e.*
                FROM   entries e
                LEFT   JOIN entry_collaborators ec ON ec.entry_id = e.id
                WHERE  e.status = 'paid'
                  AND  (e.user_id = ? OR ec.user_id = ?)
            ";
            $params = array($user_id, $user_id);
        } else {
            $sql    = "SELECT e.* FROM entries e WHERE e.status = 'paid'";
            $params = array();
        }

        if (!empty($from_date)) {
            $sql      .= " AND e.created_date >= ?";
            $params[]  = $from_date;
        }

        if (!empty($to_date)) {
            $sql      .= " AND e.created_date <= ?";
            $params[]  = $to_date;
        }

        $sql .= " ORDER BY e.created_date DESC, e.created_time DESC";

        $query = $this->_db->query($sql, $params);
        return $query->count() ? $query->results() : array();
    }

    /**
     * Get collaborators for a specific entry
     */
    public function getEntryCollaborators($entry_id) {
        $query = $this->_db->query("
            SELECT user_id, user_name, amount
            FROM   entry_collaborators
            WHERE  entry_id = ?
        ", array($entry_id));
        return $query->count() ? $query->results() : array();
    }

    /**
     * Build complete matrix data — each paid entry is one row.
     *
     * @param string|null $from_date  Filter start date (Y-m-d)
     * @param string|null $to_date    Filter end date   (Y-m-d)
     * @param int|null    $user_id    Filter by a single worker (null = all workers)
     */
    public function buildMatrix($from_date = null, $to_date = null, $user_id = null) {
        $liquidationClass = new Liquidation();

        // If a specific worker is chosen, show only that worker as a column;
        // otherwise show all active workers.
        if (!empty($user_id)) {
            $all_workers = $this->getAllWorkers();
            $workers = array_filter($all_workers, function($w) use ($user_id) {
                return $w->ID == $user_id;
            });
            $workers = array_values($workers); // re-index
        } else {
            $workers = $this->getAllWorkers();
        }

        $entries = $this->getAllPaidEntries($from_date, $to_date, $user_id);

        $matrix        = array();
        $worker_totals = array();

        // Initialise totals for each visible worker column
        foreach ($workers as $worker) {
            $worker_totals[$worker->ID] = array(
                'name'               => $worker->full_name,
                'total'              => 0,
                'worker_40_percent'  => 0,
                'company_60_percent' => 0,
                'paid_liquidations'  => 0,
                'pending_liquidations' => 0,
                'available_balance'  => 0,
            );
        }

        // Build one matrix row per entry
        foreach ($entries as $entry) {
            $service_display = ucfirst(str_replace('_', ' ', $entry->service_type));
            $collaborators   = $this->getEntryCollaborators($entry->id);

            $row = array(
                'entry_id'        => $entry->id,
                'service_type'    => $entry->service_type,
                'service_display' => $service_display,
                'date'            => $entry->created_date,
                'time'            => $entry->created_time,
                'workers'         => array()
            );

            foreach ($workers as $worker) {
                $worker_data = array(
                    'amount'           => 0,
                    'is_main_worker'   => false,
                    'is_collaborator'  => false,
                    'collaborated_with'=> array()
                );

                // Main worker on this entry
                if ($entry->user_id == $worker->ID) {
                    $worker_data['amount']         = (float) $entry->user_final_amount;
                    $worker_data['is_main_worker'] = true;

                    foreach ($collaborators as $collab) {
                        $worker_data['collaborated_with'][] = $collab->user_name;
                    }

                    $worker_totals[$worker->ID]['total'] += $worker_data['amount'];
                }

                // Collaborator on this entry
                foreach ($collaborators as $collab) {
                    if ($collab->user_id == $worker->ID) {
                        $worker_data['amount']            = (float) $collab->amount;
                        $worker_data['is_collaborator']   = true;
                        $worker_data['collaborated_with'][] = $entry->user_name;

                        $worker_totals[$worker->ID]['total'] += $worker_data['amount'];
                        break;
                    }
                }

                $row['workers'][$worker->ID] = $worker_data;
            }

            $matrix[] = $row;
        }

        // Calculate percentages and liquidations per worker
        foreach ($workers as $worker) {
            $total = $worker_totals[$worker->ID]['total'];

            $worker_40  = $total * 0.40;
            $company_60 = $total * 0.60;

            // Liquidations scoped to the chosen date range (paid ones within range,
            // pending ones always included since they block the available balance).
            $paid_liq    = $liquidationClass->getTotalLiquidatedForUser($worker->ID, 'paid', $from_date, $to_date);
            $pending_liq = $liquidationClass->getPendingLiquidationsForUser($worker->ID);

            $available = max(0, $worker_40 - $paid_liq - $pending_liq);

            $worker_totals[$worker->ID]['worker_40_percent']    = $worker_40;
            $worker_totals[$worker->ID]['company_60_percent']   = $company_60;
            $worker_totals[$worker->ID]['paid_liquidations']    = $paid_liq;
            $worker_totals[$worker->ID]['pending_liquidations'] = $pending_liq;
            $worker_totals[$worker->ID]['available_balance']    = $available;
        }

        return array(
            'workers'   => $workers,
            'matrix'    => $matrix,
            'totals'    => $worker_totals,
            'from_date' => $from_date,
            'to_date'   => $to_date,
            'user_id'   => $user_id,
        );
    }

    /**
     * Get errors
     */
    public function errors() {
        return $this->_errors;
    }
}

?>