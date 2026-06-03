<?php

class DashboardController {

    /**
     * Get dashboard statistics
     */
    public static function getDashboardStats() {
        try {
            $db = DB::getInstance();
            $today = date('Y-m-d');
            $current_month_start = date('Y-m-01');
            $current_year_start = date('Y-01-01');

            // 1. Today's Entry Count
            $todayEntriesQuery = $db->query("
                SELECT COUNT(*) as count 
                FROM entries 
                WHERE created_date = ?
            ", array($today));
            $todayEntries = $todayEntriesQuery->first()->count;

            // 2. All Entries Count
            $allEntriesQuery = $db->query("SELECT COUNT(*) as count FROM entries");
            $allEntries = $allEntriesQuery->first()->count;

            // 3. Pending Entries Count
            $pendingEntriesQuery = $db->query("
                SELECT COUNT(*) as count 
                FROM entries 
                WHERE status = 'pending'
            ");
            $pendingEntries = $pendingEntriesQuery->first()->count;

            // 4. Total Income Today
            $todayIncomeQuery = $db->query("
                SELECT SUM(total_amount) as total 
                FROM entries 
                WHERE created_date = ? 
                AND status = 'paid'
            ", array($today));
            $todayIncome = $todayIncomeQuery->first()->total ?? 0;

            // 5. Monthly Total Income
            $monthlyIncomeQuery = $db->query("
                SELECT SUM(total_amount) as total 
                FROM entries 
                WHERE created_date >= ? 
                AND status = 'paid'
            ", array($current_month_start));
            $monthlyIncome = $monthlyIncomeQuery->first()->total ?? 0;

            // 6. Yearly Total Income
            $yearlyIncomeQuery = $db->query("
                SELECT SUM(total_amount) as total 
                FROM entries 
                WHERE created_date >= ? 
                AND status = 'paid'
            ", array($current_year_start));
            $yearlyIncome = $yearlyIncomeQuery->first()->total ?? 0;

            // 7. Available Bookings (placeholder - adjust based on your booking system)
            $availableBookingsQuery = $db->query("
                SELECT COUNT(*) as count
                FROM bookings
                WHERE status = 'pending'
            ");

            $availableBookings = $availableBookingsQuery->first()->count ?? 0;

            return array(
                'today_entries' => $todayEntries,
                'all_entries' => $allEntries,
                'pending_entries' => $pendingEntries,
                'today_income' => (float) $todayIncome,
                'monthly_income' => (float) $monthlyIncome,
                'yearly_income' => (float) $yearlyIncome,
                'available_bookings' => $availableBookings
            );

        } catch (Exception $e) {
            return array(
                'today_entries' => 0,
                'all_entries' => 0,
                'pending_entries' => 0,
                'today_income' => 0,
                'monthly_income' => 0,
                'yearly_income' => 0,
                'available_bookings' => 0
            );
        }
    }

    /**
     * Get today's live activity entries
     */
    public static function getTodayLiveEntries($limit = 10) {
        try {
            $db = DB::getInstance();
            $today = date('Y-m-d');

            $query = $db->query("
                SELECT * 
                FROM entries 
                WHERE created_date = ?
                ORDER BY created_time DESC
                LIMIT ?
            ", array($today, $limit));

            if ($query->count()) {
                return $query->results();
            }
            return array();

        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get collaborators for an entry
     */
    public static function getCollaborators($entry_id) {
        try {
            $db = DB::getInstance();
            $query = $db->query("
                SELECT user_name, amount 
                FROM entry_collaborators 
                WHERE entry_id = ?
            ", array($entry_id));

            if ($query->count()) {
                return $query->results();
            }
            return array();

        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get worker earnings summary from matrix (paid entries only)
     */

    public static function getWorkerEarningsSummary() {
    try {
        $db = DB::getInstance();
        $liquidationClass = new Liquidation();
        
        // Get all active workers
        $workersQuery = $db->query("
            SELECT ID, firstname, lastname, 
            CONCAT(firstname, ' ', lastname) as full_name 
            FROM app_users 
            WHERE state = 'activated' 
            ORDER BY firstname ASC
        ");
        
        if (!$workersQuery->count()) {
            return array();
        }
        
        $workers = $workersQuery->results();
        $summary = array();

        foreach ($workers as $worker) {
            // Get solo earnings from paid entries
            $soloQuery = $db->query("
                SELECT SUM(user_final_amount) as total 
                FROM entries 
                WHERE user_id = ? 
                AND status = 'paid'
            ", array($worker->ID));
            $soloTotal = $soloQuery->first()->total ?? 0;

            // Get collaboration earnings from paid entries
            $collabQuery = $db->query("
                SELECT SUM(ec.amount) as total 
                FROM entry_collaborators ec
                INNER JOIN entries e ON ec.entry_id = e.id
                WHERE ec.user_id = ? 
                AND e.status = 'paid'
            ", array($worker->ID));
            $collabTotal = $collabQuery->first()->total ?? 0;

            $totalIncome = (float) $soloTotal + (float) $collabTotal;
            $worker_40_percent = $totalIncome * 0.40;
            
            // Get liquidations
            $paid_liquidations = $liquidationClass->getTotalLiquidatedForUser($worker->ID, 'paid');
            $pending_liquidations = $liquidationClass->getPendingLiquidationsForUser($worker->ID);
            
            // Calculate available amount (after deducting paid and pending liquidations)
            $available_amount = $worker_40_percent - $paid_liquidations - $pending_liquidations;
            
            if ($totalIncome > 0) {
                $summary[] = array(
                    'user_id' => $worker->ID,
                    'name' => $worker->full_name,
                    'total_income' => $totalIncome,
                    'company_60' => $totalIncome * 0.60,
                    'worker_40' => $worker_40_percent,
                    'paid_liquidations' => $paid_liquidations,
                    'pending_liquidations' => $pending_liquidations,
                    'available_amount' => $available_amount
                );
            }
        }

        return $summary;

    } catch (Exception $e) {
        return array();
    }
}
    // public static function getWorkerEarningsSummary() {
    //     try {
    //         $db = DB::getInstance();
            
    //         // Get all active workers
    //         $workersQuery = $db->query("
    //             SELECT ID, firstname, lastname, 
    //             CONCAT(firstname, ' ', lastname) as full_name 
    //             FROM app_users 
    //             WHERE state = 'activated' 
    //             ORDER BY firstname ASC
    //         ");
            
    //         if (!$workersQuery->count()) {
    //             return array();
    //         }
            
    //         $workers = $workersQuery->results();
    //         $summary = array();

    //         foreach ($workers as $worker) {
    //             // Get solo earnings from paid entries
    //             $soloQuery = $db->query("
    //                 SELECT SUM(user_final_amount) as total 
    //                 FROM entries 
    //                 WHERE user_id = ? 
    //                 AND status = 'paid'
    //             ", array($worker->ID));
    //             $soloTotal = $soloQuery->first()->total ?? 0;

    //             // Get collaboration earnings from paid entries
    //             $collabQuery = $db->query("
    //                 SELECT SUM(ec.amount) as total 
    //                 FROM entry_collaborators ec
    //                 INNER JOIN entries e ON ec.entry_id = e.id
    //                 WHERE ec.user_id = ? 
    //                 AND e.status = 'paid'
    //             ", array($worker->ID));
    //             $collabTotal = $collabQuery->first()->total ?? 0;

    //             $totalIncome = (float) $soloTotal + (float) $collabTotal;
                
    //             if ($totalIncome > 0) {
    //                 $summary[] = array(
    //                     'user_id' => $worker->ID,
    //                     'name' => $worker->full_name,
    //                     'total_income' => $totalIncome,
    //                     'company_60' => $totalIncome * 0.60,
    //                     'worker_40' => $totalIncome * 0.40
    //                 );
    //             }
    //         }

    //         return $summary;

    //     } catch (Exception $e) {
    //         return array();
    //     }
    // }

  public static function getLast24HoursEntries($limit = 50) {
    try {
        $db = DB::getInstance();
        
        // Calculate the cutoff datetime (24 hours ago)
        $cutoff_timestamp = time() - (24 * 60 * 60); // 24 hours in seconds
        $cutoff_date = date('Y-m-d', $cutoff_timestamp);
        $cutoff_time = date('H:i:s', $cutoff_timestamp);
        
        // Ensure limit is an integer
        $limit = (int) $limit;
        
        // Get entries from last 24 hours
        // IMPORTANT: LIMIT is NOT a parameter, it's directly in the query
        $query = $db->query("
            SELECT * 
            FROM entries 
            WHERE 
                (created_date > ?) 
                OR 
                (created_date = ? AND created_time >= ?)
            ORDER BY created_date DESC, created_time DESC
            LIMIT " . $limit . "
        ", array($cutoff_date, $cutoff_date, $cutoff_time));

        if ($query->count()) {
            return $query->results();
        }
        return array();

    } catch (Exception $e) {
        error_log("Error fetching last 24 hours entries: " . $e->getMessage());
        return array();
    }
}

}

?>