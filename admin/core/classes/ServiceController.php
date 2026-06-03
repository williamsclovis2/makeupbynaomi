<?php

class ServiceController {

    // ADD NEW SERVICE
    public static function add() {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $prfx = 'register-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SUBMIT[end($ar)] = $val;
            }
        }

        $validate = new Validate();
        $validation = $validate->check($_SUBMIT, array(
            'service_name' => array(
                'name' => 'Service Name',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $serviceClass = new Service();

            $service_name = trim($_SUBMIT['service_name']);
            $default_amount = isset($_SUBMIT['default_amount']) && !empty($_SUBMIT['default_amount']) ? $_SUBMIT['default_amount'] : 0;

            // Check if service name already exists
            if ($serviceClass->serviceExists($service_name)) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = "A service with this name already exists.";
            }

            // Get logged in user ID
            global $session_user_ID;
            $created_by = $session_user_ID;

            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $current_date = date('Y-m-d H:i:s');
                    
                    $service_id = $serviceClass->insert(array(
                        'service_name' => $service_name,
                        'default_amount' => $default_amount,
                        'status' => 'active', // New services are active by default
                        'created_by' => $created_by,
                        'created_at' => $current_date
                    ));

                    Session::put('success', 'Service has been created successfully!');
                } catch (Exception $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }
            }
        } else {
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        }

        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $diagnoArray
            ];
        } else {
            return (object) [
                'ERRORS' => false,
                'SUCCESS' => true,
                'ERRORS_SCRIPT' => ""
            ];
        }
    }

    // UPDATE SERVICE
    public static function update() {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $prfx = 'register-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SUBMIT[end($ar)] = $val;
            }
        }

        $validate = new Validate();
        $validation = $validate->check($_SUBMIT, array(
            'service_id' => array(
                'name' => 'Service ID',
                'required' => true
            ),
            'service_name' => array(
                'name' => 'Service Name',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $serviceClass = new Service();

            $service_id = $_SUBMIT['service_id'];
            $service_name = trim($_SUBMIT['service_name']);
            $default_amount = isset($_SUBMIT['default_amount']) && !empty($_SUBMIT['default_amount']) ? $_SUBMIT['default_amount'] : 0;

            // Check if service exists
            if (!$serviceClass->find($service_id)) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = "Service not found.";
            }

            // Check if service name already exists (excluding current service)
            if ($serviceClass->serviceExists($service_name, $service_id)) {
                $diagnoArray[0] = "ERRORS_FOUND";
                $diagnoArray[] = "A service with this name already exists.";
            }

            if ($diagnoArray[0] == 'NO_ERRORS') {
                try {
                    $serviceClass->update(array(
                        'service_name' => $service_name,
                        'default_amount' => $default_amount
                    ), $service_id);

                    Session::put('success', 'Service has been updated successfully!');
                } catch (Exception $e) {
                    $diagnoArray[0] = "ERRORS_FOUND";
                    $diagnoArray[] = $e->getMessage();
                }
            }
        } else {
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        }

        if ($diagnoArray[0] == 'ERRORS_FOUND') {
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $diagnoArray
            ];
        } else {
            return (object) [
                'ERRORS' => false,
                'SUCCESS' => true,
                'ERRORS_SCRIPT' => ""
            ];
        }
    }

    // CHANGE SERVICE STATUS (ACTIVATE/DEACTIVATE)
    public static function changeStatus($status, $service_id) {
        try {
            $serviceClass = new Service();
            
            // Find the service
            if (!$serviceClass->find($service_id)) {
                throw new Exception("Service not found");
            }
            
            // Valid statuses
            $valid_statuses = ['active', 'inactive'];
            
            if (!in_array($status, $valid_statuses)) {
                throw new Exception("Invalid status");
            }
            
            // Update status
            $serviceClass->update(array(
                'status' => $status
            ), $service_id);
            
            $status_text = ($status == 'active') ? 'activated' : 'deactivated';
            Session::put('success', 'Service has been ' . $status_text . ' successfully!');
            
            return (object) [
                'ERRORS' => false,
                'SUCCESS' => true
            ];
            
        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $e->getMessage()
            ];
        }
    }

    // DELETE SERVICE (OPTIONAL - IF YOU WANT TO PERMANENTLY DELETE)
    public static function delete($service_id) {
        try {
            $serviceClass = new Service();
            $db = DB::getInstance();
            
            // Find the service
            if (!$serviceClass->find($service_id)) {
                throw new Exception("Service not found");
            }
            
            // Check if service is being used in entries
            $checkEntries = $db->query("SELECT COUNT(*) as count FROM entries WHERE service_type = ?", array($service_id));
            if ($checkEntries->count() && $checkEntries->first()->count > 0) {
                throw new Exception("Cannot delete service as it is being used in entries. Please deactivate instead.");
            }
            
            // Delete the service
            $db->delete('services', array('id', '=', $service_id));
            
            Session::put('success', 'Service has been deleted successfully!');
            
            return (object) [
                'ERRORS' => false,
                'SUCCESS' => true
            ];
            
        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) [
                'ERRORS' => true,
                'ERRORS_SCRIPT' => $e->getMessage()
            ];
        }
    }
}

?>