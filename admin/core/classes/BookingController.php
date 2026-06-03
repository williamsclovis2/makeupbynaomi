<?php
/**
 * BOOKING CONTROLLER - INTEGRATED WITH BOOKING MODEL
 */

class BookingController {
    
    /**
     * Create new booking (called from controller.php)
     * This is an alias for add() method
     */
    public static function create() {
        return self::add();
    }
    
    /**
     * Add new booking
     */
    public static function add() {
        global $session_user_ID;

        if (!isset($session_user_ID) || empty($session_user_ID)) {
            throw new Exception("User session not found. Please login again.");
        }

        $prfx = 'register-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SUBMIT[end($ar)] = $val;
            }
        }

        // Handle service_type array
        $service_types = [];
        if (isset($_SUBMIT['service_type']) && is_array($_SUBMIT['service_type'])) {
            foreach ($_SUBMIT['service_type'] as $service) {
                if ($service === 'other') {
                    if (isset($_SUBMIT['other_service_name']) && !empty($_SUBMIT['other_service_name'])) {
                        $service_types[] = $_SUBMIT['other_service_name'];
                    } else {
                        Session::put('errors', 'Please specify the custom service name');
                        return (object) ['ERRORS' => true];
                    }
                } else {
                    $service_types[] = $service;
                }
            }
        } else {
            Session::put('errors', 'Please select at least one service');
            return (object) ['ERRORS' => true];
        }

        // Convert to comma-separated string
        $_SUBMIT['service_type'] = implode(', ', $service_types);

        // Validation - email and expected_price are optional
        $validate = new Validate();
        $validation = $validate->check($_SUBMIT, array(
            'client_name' => array(
                'name' => 'Client Name',
                'required' => true
            ),
            'client_phone' => array(
                'name' => 'Phone Number',
                'required' => true
            ),
            'service_type' => array(
                'name' => 'Service Type',
                'required' => true
            ),
            'booking_date' => array(
                'name' => 'Booking Date',
                'required' => true
            ),
            'booking_time' => array(
                'name' => 'Booking Time',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $bookingClass = new Booking();

            $client_name = $_SUBMIT['client_name'];
            $client_phone = $_SUBMIT['client_phone'];
            $client_email = @$_SUBMIT['client_email']; // Optional
            $service_type = $_SUBMIT['service_type'];
            $preferred_worker = @$_SUBMIT['preferred_worker'];
            $booking_date = $_SUBMIT['booking_date'];
            $booking_time = $_SUBMIT['booking_time'];
            $expected_price = @$_SUBMIT['expected_price']; // Optional
            $notes = @$_SUBMIT['notes'];
            
            // Get worker name if selected
            $preferred_worker_name = '';
            if (!empty($preferred_worker)) {
                $db = DB::getInstance();
                $workerQuery = $db->query("SELECT firstname, lastname FROM app_users WHERE ID = ?", array($preferred_worker));
                if($workerQuery->count()) {
                    $worker_data = $workerQuery->first();
                    $preferred_worker_name = $worker_data->firstname . ' ' . $worker_data->lastname;
                }
            }

            try {
                // Check for overlapping bookings
                $overlapCheck = $bookingClass->checkOverlap($booking_date, $booking_time);
                
                $booking_id = $bookingClass->insert(array(
                    'client_name' => $client_name,
                    'client_phone' => $client_phone,
                    'client_email' => $client_email,
                    'service_type' => $service_type,
                    'preferred_worker_id' => $preferred_worker,
                    'preferred_worker_name' => $preferred_worker_name,
                    'booking_date' => $booking_date,
                    'booking_time' => $booking_time,
                    'expected_price' => $expected_price,
                    'notes' => $notes,
                    'status' => 'pending',
                    'created_by' => $session_user_ID,
                    'created_date' => date('Y-m-d')
                ));

                // Show warning if there's an overlap
                if ($overlapCheck['has_overlap']) {
                    Session::put('success', 'Booking created successfully! WARNING: This booking overlaps with another booking at the same time.');
                } else {
                    Session::put('success', 'Booking created successfully!');
                }
                
                return (object) ['ERRORS' => false, 'SUCCESS' => true];
            } catch (Exception $e) {
                Session::put('errors', $e->getMessage());
                return (object) ['ERRORS' => true];
            }
        } else {
            Session::put('errors', $validate->errors());
            return (object) ['ERRORS' => true];
        }
    }

    /**
     * Update booking
     */
    public static function update() {
        try {
            $booking_id = $_POST['booking_id'];
            
            // Handle service_type array
            $service_types = [];
            if (isset($_POST['service_type']) && is_array($_POST['service_type'])) {
                foreach ($_POST['service_type'] as $service) {
                    if ($service === 'other') {
                        if (isset($_POST['other_service_name']) && !empty($_POST['other_service_name'])) {
                            $service_types[] = $_POST['other_service_name'];
                        } else {
                            Session::put('errors', 'Please specify the custom service name');
                            return (object) ['ERRORS' => true];
                        }
                    } else {
                        $service_types[] = $service;
                    }
                }
            } else {
                Session::put('errors', 'Please select at least one service');
                return (object) ['ERRORS' => true];
            }

            $service_type = implode(', ', $service_types);
            
            // Get worker name if changed
            $preferred_worker_id = $_POST['preferred_worker'];
            $preferred_worker_name = '';
            if (!empty($preferred_worker_id)) {
                $db = DB::getInstance();
                $workerQuery = $db->query("SELECT firstname, lastname FROM app_users WHERE ID = ?", array($preferred_worker_id));
                if($workerQuery->count()) {
                    $worker_data = $workerQuery->first();
                    $preferred_worker_name = $worker_data->firstname . ' ' . $worker_data->lastname;
                }
            }
            
            $bookingClass = new Booking();
            if (!$bookingClass->find($booking_id)) {
                throw new Exception("Booking not found");
            }
            
            // Check for overlapping bookings (exclude current booking)
            $overlapCheck = $bookingClass->checkOverlap($_POST['booking_date'], $_POST['booking_time'], $booking_id);
            
            $bookingClass->update(array(
                'client_name' => $_POST['client_name'],
                'client_phone' => $_POST['client_phone'],
                'client_email' => @$_POST['client_email'],
                'service_type' => $service_type,
                'preferred_worker_id' => $preferred_worker_id,
                'preferred_worker_name' => $preferred_worker_name,
                'booking_date' => $_POST['booking_date'],
                'booking_time' => $_POST['booking_time'],
                'expected_price' => @$_POST['price'],
                'notes' => @$_POST['notes']
            ), $booking_id);
            
            // Show warning if there's an overlap
            if ($overlapCheck['has_overlap']) {
                Session::put('success', 'Booking updated successfully! WARNING: This booking overlaps with another booking at the same time.');
            } else {
                Session::put('success', 'Booking updated successfully!');
            }
            
            return (object) ['ERRORS' => false, 'SUCCESS' => true];
            
        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true];
        }
    }

    /**
     * Cancel booking
     * Updated to accept parameter
     */
    public static function cancel($booking_id = null) {
        try {
            // Get booking_id from parameter or $_POST
            if ($booking_id === null) {
                $booking_id = $_POST['booking_id'];
            }
            
            $bookingClass = new Booking();
            if (!$bookingClass->find($booking_id)) {
                throw new Exception("Booking not found");
            }
            
            $bookingClass->update(array('status' => 'cancelled'), $booking_id);
            
            Session::put('success', 'Booking cancelled successfully!');
            return (object) ['ERRORS' => false, 'SUCCESS' => true];
            
        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true];
        }
    }

    /**
     * Alias for cancel method
     */
    public static function cancelBooking($booking_id = null) {
        return self::cancel($booking_id);
    }

    /**
     * Create entry from booking
     * Updated to accept parameter
     */
    public static function createEntry($booking_id = null) {
        global $session_user_ID;
        
        try {
            // Get booking_id from parameter or $_POST
            if ($booking_id === null) {
                $booking_id = $_POST['booking_id'];
            }
            
            $bookingClass = new Booking();
            if (!$bookingClass->find($booking_id)) {
                throw new Exception("Booking not found");
            }
            
            $booking = $bookingClass->data();
            
            if (!empty($booking->entry_id)) {
                throw new Exception("Entry already created for this booking");
            }
            
            if (empty($booking->preferred_worker_id)) {
                throw new Exception("Please assign a worker before creating entry");
            }
            
            // Create entry
            $entryClass = new NailEntry();
            $entry_id = $entryClass->insert(array(
                'user_id' => $booking->preferred_worker_id,
                'user_name' => $booking->preferred_worker_name,
                'entry_type' => 'solo',
                'service_type' => $booking->service_type,
                'total_amount' => $booking->expected_price ?? 0,
                'user_final_amount' => $booking->expected_price ?? 0,
                'notes' => 'From booking #' . $booking_id . ($booking->notes ? ' - ' . $booking->notes : ''),
                'status' => 'pending',
                'created_by' => $session_user_ID,
                'created_date' => date('Y-m-d'),
                'created_time' => date('H:i:s')
            ));
            
            // Update booking with entry_id and mark status as booked
            $bookingClass->update(array(
                'entry_id' => $entry_id,
                'status'   => 'booked'
            ), $booking_id);
            
            Session::put('success', 'Entry created successfully from booking!');
            return (object) ['ERRORS' => false, 'SUCCESS' => true];
            
        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) ['ERRORS' => true];
        }
    }

    /**
     * Alias for createEntry method
     */
    public static function createEntryFromBooking($booking_id = null) {
        return self::createEntry($booking_id);
    }

    /**
     * Get all bookings with optional filters
     * This method uses the Booking model's getAllBookings method
     */
    public static function getAllBookings($filters = array()) {
        $bookingClass = new Booking();
        return $bookingClass->getAllBookings($filters);
    }

    /**
     * Get all workers
     */
    public static function getAllWorkers() {
        $db = DB::getInstance();
        $query = $db->query("SELECT ID, firstname, lastname FROM app_users WHERE (groups = 'Worker' OR groups = 'Admin') AND (state = 'active' OR state = 'Activated') ORDER BY firstname ASC");
        return $query->results();
    }
}
?>