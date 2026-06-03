<?php

class Booking {

    private $_db,
            $_data,
            $_count = 0,
            $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // CREATE BOOKING
    public function insert($fields = array()) {
        if (!$this->_db->insert('bookings', $fields)) {
            throw new Exception("There was a problem creating the booking.");
        }
        
        // Return the last inserted ID
        return $this->_db->lastInsertId();
    }

    // UPDATE BOOKING
    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('bookings', $id, $fields)) {
            throw new Exception('There was a problem updating the booking.');
        }
    }

    // FIND BOOKING
    public function find($booking_id = null) {
        if ($booking_id) {
            $data = $this->_db->query("SELECT * FROM `bookings` WHERE `id` = ?", array($booking_id));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // GET ALL BOOKINGS with filters
    public function getAllBookings($filters = array()) {
        $sql = "SELECT * FROM bookings WHERE status != 'cancelled' AND (entry_id IS NULL OR entry_id = '')";  // <-- NEW LINE
        $params = array();

        // Apply filters
        if (isset($filters['from_date']) && !empty($filters['from_date'])) {
            $sql .= " AND booking_date >= ?";
            $params[] = $filters['from_date'];
        }

        if (isset($filters['to_date']) && !empty($filters['to_date'])) {
            $sql .= " AND booking_date <= ?";
            $params[] = $filters['to_date'];
        }

        if (isset($filters['keyword']) && !empty($filters['keyword'])) {
            $sql .= " AND (client_name LIKE ? OR client_phone LIKE ? OR client_email LIKE ?)";
            $params[] = '%' . $filters['keyword'] . '%';
            $params[] = '%' . $filters['keyword'] . '%';
            $params[] = '%' . $filters['keyword'] . '%';
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (isset($filters['worker_id']) && !empty($filters['worker_id'])) {
            $sql .= " AND preferred_worker_id = ?";
            $params[] = $filters['worker_id'];
        }

        $sql .= " ORDER BY booking_date DESC, booking_time DESC";

        $data = $this->_db->query($sql, $params);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
            return $this->_data;
        }
        return array();
    }

    // CHECK FOR OVERLAPPING BOOKING (same date and time)
    public function checkOverlap($booking_date, $booking_time, $exclude_booking_id = null) {
        $sql = "
            SELECT * FROM bookings 
            WHERE booking_date = ? 
            AND booking_time = ? 
            AND status != 'cancelled'
        ";
        $params = array($booking_date, $booking_time);

        // Exclude current booking if editing
        if ($exclude_booking_id) {
            $sql .= " AND id != ?";
            $params[] = $exclude_booking_id;
        }

        $query = $this->_db->query($sql, $params);
        
        if ($query->count()) {
            return array(
                'has_overlap' => true,
                'existing_booking' => $query->first(),
                'all_overlaps' => $query->results() // Return all overlapping bookings
            );
        }
        
        return array('has_overlap' => false);
    }

    // MARK BOOKING AS OVERLAPPED
    public function markAsOverlapped($booking_id) {
        $this->update(array(
            'is_overlapped' => 1
        ), $booking_id);
    }

    // GET OVERLAPPED BOOKINGS - IMPROVED to check actual overlaps in real-time
    public function getOverlappedBookings() {
        // Get all bookings grouped by date and time to find overlaps
        $sql = "
            SELECT b1.id
            FROM bookings b1
            INNER JOIN bookings b2 
                ON b1.booking_date = b2.booking_date 
                AND b1.booking_time = b2.booking_time
                AND b1.id != b2.id
            WHERE b1.status != 'cancelled' 
            AND b2.status != 'cancelled'
            GROUP BY b1.id
        ";
        
        $query = $this->_db->query($sql);
        
        $ids = array();
        if ($query->count()) {
            foreach ($query->results() as $row) {
                $ids[] = $row->id;
            }
        }
        return $ids;
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