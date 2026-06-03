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

            // 7. Available Bookings
            $availableBookingsQuery = $db->query("
                SELECT COUNT(*) as count
                FROM bookings
                WHERE status = 'pending'
            ");
            $availableBookings = $availableBookingsQuery->first()->count ?? 0;

            return array(
                'today_entries'     => $todayEntries,
                'all_entries'       => $allEntries,
                'pending_entries'   => $pendingEntries,
                'today_income'      => (float) $todayIncome,
                'monthly_income'    => (float) $monthlyIncome,
                'yearly_income'     => (float) $yearlyIncome,
                'available_bookings'=> $availableBookings
            );

        } catch (Exception $e) {
            return array(
                'today_entries'     => 0,
                'all_entries'       => 0,
                'pending_entries'   => 0,
                'today_income'      => 0,
                'monthly_income'    => 0,
                'yearly_income'     => 0,
                'available_bookings'=> 0
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
     * Get the current week's Sunday-to-Saturday date range.
     * Week cycle: Sunday 00:00:00 → Saturday 23:59:59
     * After Saturday ends, the table resets automatically on the next Sunday.
     *
     * @return array ['week_start' => 'Y-m-d', 'week_end' => 'Y-m-d', 'label' => string]
     */
    public static function getCurrentWeekRange() {
        $today       = new DateTime();
        $day_of_week = (int) $today->format('w'); // 0=Sun, 1=Mon ... 6=Sat

        // Calculate Sunday (start of this cycle)
        $sunday = clone $today;
        $sunday->modify('-' . $day_of_week . ' days');
        $sunday->setTime(0, 0, 0);

        // Saturday = Sunday + 6 days (end of cycle)
        $saturday = clone $sunday;
        $saturday->modify('+6 days');
        $saturday->setTime(23, 59, 59);

        return array(
            'week_start' => $sunday->format('Y-m-d'),
            'week_end'   => $saturday->format('Y-m-d'),
            'label'      => $sunday->format('d M Y') . ' – ' . $saturday->format('d M Y')
        );
    }

    /**
     * Get worker earnings summary for the CURRENT WEEK (Sunday–Saturday) only.
     *
     * Rules:
     * - Only paid entries whose created_date falls within this week are counted.
     * - Workers with zero income this week are excluded from the table entirely.
     * - Liquidations are also scoped to this week's earnings cycle.
     * - The table naturally "resets" each Sunday because the date range shifts.
     *
     * Week cycle: Sunday 00:00:00 → Saturday 23:59:59
     * After Saturday ends, all calculations disappear and a new cycle begins on Sunday.
     */
    public static function getWorkerEarningsSummary() {
        try {
            $db               = DB::getInstance();
            $liquidationClass = new Liquidation();

            // ── Get this week's Sunday–Saturday range ────────────────────────
            $week       = self::getCurrentWeekRange();
            $week_start = $week['week_start'];
            $week_end   = $week['week_end'];

            // ── Fetch all active workers ──────────────────────────────────────
            $workersQuery = $db->query("
                SELECT ID, firstname, lastname,
                       CONCAT(firstname, ' ', lastname) AS full_name
                FROM   app_users
                WHERE  state = 'activated'
                ORDER  BY firstname ASC
            ");

            if (!$workersQuery->count()) {
                return array();
            }

            $workers = $workersQuery->results();
            $summary = array();

            foreach ($workers as $worker) {

                // ── Solo earnings this week (paid entries only) ───────────────
                $soloQuery = $db->query("
                    SELECT SUM(user_final_amount) AS total
                    FROM   entries
                    WHERE  user_id      = ?
                      AND  status       = 'paid'
                      AND  created_date >= ?
                      AND  created_date <= ?
                ", array($worker->ID, $week_start, $week_end));
                $soloTotal = (float) ($soloQuery->first()->total ?? 0);

                // ── Collaboration earnings this week (paid entries only) ──────
                $collabQuery = $db->query("
                    SELECT SUM(ec.amount) AS total
                    FROM   entry_collaborators ec
                    INNER  JOIN entries e ON ec.entry_id = e.id
                    WHERE  ec.user_id     = ?
                      AND  e.status       = 'paid'
                      AND  e.created_date >= ?
                      AND  e.created_date <= ?
                ", array($worker->ID, $week_start, $week_end));
                $collabTotal = (float) ($collabQuery->first()->total ?? 0);

                $totalIncome = $soloTotal + $collabTotal;

                // Skip workers with no income this week — table stays empty for them
                if ($totalIncome <= 0) {
                    continue;
                }

                $worker_40_percent = $totalIncome * 0.40;

                // ── Liquidations scoped to this week's cycle ─────────────────
                // "Paid liquidations" = liquidations that were already paid out
                //   and whose liquidation_date falls within this week.
                // "Pending liquidations" = any pending liquidation for this worker
                //   (pending ones block available balance regardless of date).
                $paid_liquidations    = $liquidationClass->getTotalLiquidatedForUser($worker->ID, 'paid', $week_start, $week_end);
                $pending_liquidations = $liquidationClass->getPendingLiquidationsForUser($worker->ID, $week_start, $week_end);
                // Available = worker's 40% share minus what has already been paid/pending
                $available_amount = $worker_40_percent - $paid_liquidations - $pending_liquidations;

                $summary[] = array(
                    'user_id'              => $worker->ID,
                    'name'                 => $worker->full_name,
                    'total_income'         => $totalIncome,
                    'company_60'           => $totalIncome * 0.60,
                    'worker_40'            => $worker_40_percent,
                    'paid_liquidations'    => $paid_liquidations,
                    'pending_liquidations' => $pending_liquidations,
                    'available_amount'     => max(0, $available_amount), // never go negative in display
                    'week_label'           => $week['label'],
                );
            }

            return $summary;

        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Get entries from the last 24 hours
     */
    public static function getLast24HoursEntries($limit = 50) {
        try {
            $db = DB::getInstance();

            $cutoff_timestamp = time() - (24 * 60 * 60);
            $cutoff_date      = date('Y-m-d', $cutoff_timestamp);
            $cutoff_time      = date('H:i:s', $cutoff_timestamp);
            $limit            = (int) $limit;

            $query = $db->query("
                SELECT *
                FROM   entries
                WHERE  (created_date >  ?)
                   OR  (created_date =  ? AND created_time >= ?)
                ORDER  BY created_date DESC, created_time DESC
                LIMIT  " . $limit . "
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