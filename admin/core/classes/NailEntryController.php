<?php
// require_once 'NailEntry.php';
// require_once 'EntryCollaborator.php';
class NailEntryController {

   public static function add() {
         error_log("POST data: " . print_r($_POST, true));
    
            global $session_user_ID;

            if (!isset($session_user_ID) || empty($session_user_ID)) {
                throw new Exception("User session not found. Please login again.");
            }

            $diagnoArray[0] = 'NO_ERRORS';
            $validate = new \Validate();

            $prfx = 'register-';
            foreach ($_POST as $index => $val) {
                $ar = explode($prfx, $index);
                if (count($ar)) {
                    $_SUBMIT[end($ar)] = $val;
                }
            }

            // Handle service_type - now it's an array
            $service_types = [];
            if (isset($_SUBMIT['service_type']) && is_array($_SUBMIT['service_type'])) {
                foreach ($_SUBMIT['service_type'] as $service) {
                    if ($service === 'other') {
                        if (isset($_SUBMIT['other_service_name']) && !empty($_SUBMIT['other_service_name'])) {
                            $service_types[] = $_SUBMIT['other_service_name'];
                        } else {
                            return (object) [
                                'ERRORS' => true,
                                'ERRORS_SCRIPT' => ['Please specify the service name for "Other" option']
                            ];
                        }
                    } else {
                        $service_types[] = $service;
                    }
                }
            } else {
                return (object) [
                    'ERRORS' => true,
                    'ERRORS_SCRIPT' => ['Please select at least one service type']
                ];
            }

            $_SUBMIT['service_type'] = implode(', ', $service_types);

            $validate = new Validate();
            $validation = $validate->check($_SUBMIT, array(
                'user_id' => array(
                    'name' => 'Worker',
                    'required' => true
                ),
                'service_type' => array(
                    'name' => 'Service Type',
                    'required' => true
                ),
                'amount' => array(
                    'name' => 'Amount',
                    'required' => true
                ),
                'user_final_amount' => array(
                    'name' => 'Worker Final Amount',
                    'required' => true
                )
            ));

            if ($validation->passed()) {
                $entryClass = new NailEntry();
                $collaboratorClass = new EntryCollaborator();

                $user_id = @$_SUBMIT['user_id'];
                $service_type = @$_SUBMIT['service_type'];
                $total_amount = @$_SUBMIT['amount'];
                $payment_method = @$_SUBMIT['payment_method'];
                $user_final_amount = @$_SUBMIT['user_final_amount'];
                $notes = @$_SUBMIT['notes'];
                $collaboration_check = isset($_SUBMIT['collaboration_check']) ? 1 : 0;
                
                $db = DB::getInstance();
                $userQuery = $db->query("SELECT firstname, lastname FROM app_users WHERE ID = ?", array($user_id));
                if($userQuery->count()) {
                    $worker_data = $userQuery->first();
                    $user_name = $worker_data->firstname . ' ' . $worker_data->lastname;
                } else {
                    $user_name = 'Unknown';
                }

                $created_by = $session_user_ID;
                $entry_type = ($collaboration_check == 1) ? 'collab' : 'solo';

                if ($diagnoArray[0] == 'NO_ERRORS') {
                    try {
                        $current_date = date('Y-m-d');
                        $current_time = date('H:i:s');
                        
                        $entry_id = $entryClass->insert(array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'entry_type' => $entry_type,
                            'service_type' => $service_type,
                            'total_amount' => $total_amount,
                            'payment_method' => $payment_method,
                            'user_final_amount' => $user_final_amount,
                            'notes' => $notes,
                            'status' => 'pending',
                            'created_by' => $created_by,
                            'created_date' => $current_date,
                            'created_time' => $current_time
                        ));

                        if ($collaboration_check == 1 && isset($_SUBMIT['coworkers']) && is_array($_SUBMIT['coworkers'])) {
                            foreach ($_SUBMIT['coworkers'] as $coworker_id) {
                                if (isset($_SUBMIT['collab_amounts'][$coworker_id]) && !empty($_SUBMIT['collab_amounts'][$coworker_id])) {
                                    $coworker_amount = $_SUBMIT['collab_amounts'][$coworker_id];
                                    
                                    $coworkerQuery = $db->query("SELECT firstname, lastname FROM app_users WHERE ID = ?", array($coworker_id));
                                    if($coworkerQuery->count()) {
                                        $coworker_data = $coworkerQuery->first();
                                        $coworker_name = $coworker_data->firstname . ' ' . $coworker_data->lastname;
                                    } else {
                                        $coworker_name = 'Unknown';
                                    }

                                    $collaboratorClass->insert(array(
                                        'entry_id' => $entry_id,
                                        'user_id' => $coworker_id,
                                        'user_name' => $coworker_name,
                                        'amount' => $coworker_amount,
                                        'created_date' => $current_date
                                    ));
                                }
                            }
                        }

                        Session::put('success', 'Entry has been recorded successfully!');
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


    // -------------------------------------------------------
    // EDIT ENTRY
    // -------------------------------------------------------
    public static function edit($entry_id) {
        try {
            $entry_id = (int) $entry_id;

            if (!$entry_id) {
                throw new Exception("Invalid entry ID.");
            }

            $entryClass        = new NailEntry();
            $collaboratorClass = new EntryCollaborator();

            if (!$entryClass->find($entry_id)) {
                throw new Exception("Entry not found.");
            }

            // Parse submitted fields using the same register- prefix convention
            $prfx    = 'register-';
            $_SUBMIT = [];
            foreach ($_POST as $index => $val) {
                $ar = explode($prfx, $index);
                if (count($ar) > 1) {
                    $_SUBMIT[end($ar)] = $val;
                }
            }

            // payment_method is not prefixed in the form
            if (isset($_POST['payment_method'])) {
                $_SUBMIT['payment_method'] = $_POST['payment_method'];
            }

            $validate   = new Validate();
            $validation = $validate->check($_SUBMIT, array(
                'user_id' => array(
                    'name'     => 'Worker',
                    'required' => true
                ),
                'service_type' => array(
                    'name'     => 'Service Type',
                    'required' => true
                ),
                'amount' => array(
                    'name'     => 'Amount',
                    'required' => true
                ),
                'user_final_amount' => array(
                    'name'     => 'Worker Final Amount',
                    'required' => true
                )
            ));

            if (!$validation->passed()) {
                return (object) [
                    'ERRORS'        => true,
                    'ERRORS_SCRIPT' => $validate->getErrorLocation()
                ];
            }

            $user_id             = $_SUBMIT['user_id'];
            $service_type        = trim($_SUBMIT['service_type']);
            $total_amount        = $_SUBMIT['amount'];
            $payment_method      = @$_SUBMIT['payment_method'];
            $user_final_amount   = $_SUBMIT['user_final_amount'];
            $notes               = @$_SUBMIT['notes'];
            $status              = @$_SUBMIT['status'];
            $collaboration_check = isset($_SUBMIT['collaboration_check']) ? 1 : 0;
            $entry_type          = ($collaboration_check == 1) ? 'collab' : 'solo';

            // Validate status
            $valid_statuses = ['pending', 'completed', 'paid', 'cancelled'];
            if (!in_array($status, $valid_statuses)) {
                $status = 'pending';
            }

            // Resolve worker name
            $db        = DB::getInstance();
            $userQuery = $db->query("SELECT firstname, lastname FROM app_users WHERE ID = ?", array($user_id));
            if ($userQuery->count()) {
                $worker    = $userQuery->first();
                $user_name = $worker->firstname . ' ' . $worker->lastname;
            } else {
                $user_name = 'Unknown';
            }

            // Update the main entry
            $entryClass->update(array(
                'user_id'           => $user_id,
                'user_name'         => $user_name,
                'entry_type'        => $entry_type,
                'service_type'      => $service_type,
                'total_amount'      => $total_amount,
                'payment_method'    => $payment_method,
                'user_final_amount' => $user_final_amount,
                'notes'             => $notes,
                'status'            => $status,
            ), $entry_id);

            // -----------------------------------------------
            // Collaboration logic
            // Always wipe existing collaborators, re-insert if collab is checked
            // -----------------------------------------------
            $db->query("DELETE FROM entry_collaborators WHERE entry_id = ?", array($entry_id));

            if ($collaboration_check == 1 && isset($_SUBMIT['coworkers']) && is_array($_SUBMIT['coworkers'])) {
                $current_date = date('Y-m-d');

                foreach ($_SUBMIT['coworkers'] as $coworker_id) {
                    // Only insert if a collab amount was provided for this worker
                    if (
                        isset($_SUBMIT['collab_amounts'][$coworker_id]) &&
                        $_SUBMIT['collab_amounts'][$coworker_id] !== ''
                    ) {
                        $coworker_amount = $_SUBMIT['collab_amounts'][$coworker_id];

                        $coworkerQuery = $db->query(
                            "SELECT firstname, lastname FROM app_users WHERE ID = ?",
                            array($coworker_id)
                        );
                        $coworker_name = $coworkerQuery->count()
                            ? $coworkerQuery->first()->firstname . ' ' . $coworkerQuery->first()->lastname
                            : 'Unknown';

                        $collaboratorClass->insert(array(
                            'entry_id'     => $entry_id,
                            'user_id'      => $coworker_id,
                            'user_name'    => $coworker_name,
                            'amount'       => $coworker_amount,
                            'created_date' => $current_date
                        ));
                    }
                }
            }

            Session::put('success', 'Entry updated successfully!');

            return (object) [
                'ERRORS'        => false,
                'SUCCESS'       => true,
                'ERRORS_SCRIPT' => ""
            ];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => [$e->getMessage()]
            ];
        }
    }


    // -------------------------------------------------------
    // CHANGE STATUS
    // -------------------------------------------------------
    public static function changeStatus($status, $entry_id) {
        try {
            $entryClass = new NailEntry();

            if (!$entryClass->find($entry_id)) {
                throw new Exception("Entry not found");
            }

            $valid_statuses = ['pending', 'completed', 'paid', 'cancelled'];

            if (!in_array($status, $valid_statuses)) {
                throw new Exception("Invalid status");
            }

            $entryClass->update(array(
                'status' => $status
            ), $entry_id);

            Session::put('success', 'Entry status updated to ' . ucfirst($status) . '!');

            return (object) [
                'ERRORS'  => false,
                'SUCCESS' => true
            ];

        } catch (Exception $e) {
            Session::put('errors', $e->getMessage());
            return (object) [
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => $e->getMessage()
            ];
        }
    }
}