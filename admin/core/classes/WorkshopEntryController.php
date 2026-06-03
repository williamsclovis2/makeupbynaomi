<?php

class WorkshopEntryController {

    public static function add($form = 'Admin') {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $error_msg = '';

        if ($form == 'Admin') {
            $prfx = 'register-';
            foreach ($_POST as $index => $val) {
                $ar = explode($prfx, $index);
                if (count($ar)) {
                    $_SUBMIT[end($ar)] = $val;
                }
            }
        }

        $str = new \Str();

        $validate_array = array();
        $validate_array_1 = array();
        $validate_array_2 = array();

        $validate_array_0 = array(
            'customer_firstname' => array(
                'name' => 'Customer First name',
                'string' => true,
                'required' => true
            ),
            'customer_lastname' => array(
                'name' => 'Customer Last name',
                'string' => true
            ),
            'customer_telephone' => array(
                'name' => 'Customer Telephone'
            ),
            'customer_email' => array(
                'name' => 'Customer Email',
                'email' => true
            ),
            'vehicle_license_no' => array(
                'name' => 'Vehicle License No.',
                'string' => true,
                'required' => true
            ),
            'vehicle_model' => array(
                'name' => 'Vehicle Model',
                'string' => true,
                'required' => true
            ),
            'service_order_no' => array(
                'name' => 'Service Order No.',
                'string' => true,
                'required' => true
            ),
            'service_advisor_name' => array(
                'name' => 'Service advisor name',
                'string' => true,
                'required' => true
            ),
            'checkin_date' => array(
                'name' => 'Checkin date',
                'string' => true,
                'required' => true
            ),
            'checkin_time' => array(
                'name' => 'Checkin time',
                'string' => true,
                'required' => true
            ),
            'promised_date' => array(
                'name' => 'Promised date',
                'string' => true,
                'required' => true
            ),
            'promised_time' => array(
                'name' => 'Promised time',
                'string' => true,
                'required' => true
            ),
            'service_type' => array(
                'name' => 'Service type',
                'string' => true,
                'required' => true
            ),
            'remarks' => array(
                'name' => 'Remarks'
            )
        );

        $validate_array = array_merge($validate_array_0, $validate_array_2);

        $validation = $validate->check($_SUBMIT, $validate_array);

        if ($validation->passed()) {


            $participantTable = new \WorkshopEntry();

            $customer_firstname = $str->sanAsName(@$_SUBMIT['customer_firstname']);
            $customer_lastname = $str->sanAsName(@$_SUBMIT['customer_lastname']);

            $customer_telephone = $str->data_in(@$_SUBMIT['customer_telephone']);
            $customer_email = $str->data_in(@$_SUBMIT['customer_email']);

            $vehicle_license_no = strtoupper($str->data_in(@$_SUBMIT['vehicle_license_no']));
            $vehicle_model = strtoupper($str->data_in(@$_SUBMIT['vehicle_model']));

            $service_order_no = strtoupper($str->sanAsName(@$_SUBMIT['service_order_no']));
            $service_advisor_name = strtoupper($str->sanAsName(@$_SUBMIT['service_advisor_name']));

            $checkin_date = $str->data_in(@$_SUBMIT['checkin_date']);
            $checkin_time = $str->data_in(@$_SUBMIT['checkin_time']);

            $promised_date = $str->data_in(@$_SUBMIT['promised_date']);
            $promised_time = $str->data_in(@$_SUBMIT['promised_time']);

            $service_type = strtoupper($str->data_in(@$_SUBMIT['service_type']));

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {

                try {
                    $participantTable->insert(array(
                        'customer_firstname' => $customer_firstname,
                        'customer_lastname' => $customer_lastname,
                        'customer_telephone' => $customer_telephone,
                        'customer_email' => $customer_email,
                        'vehicle_license_no' => $vehicle_license_no,
                        'vehicle_model' => $vehicle_model,
                        'service_order_no' => $service_order_no,
                        'service_advisor_name' => $service_advisor_name,
                        'checkin_date' => $checkin_date,
                        'checkin_time' => $checkin_time,
                        'promised_date' => $promised_date,
                        'promised_time' => $promised_time,
                        'service_type' => $service_type,
                        'posting_date' => Dates::get('d-m-Y', $seconds),
                        'status' => "",
                        'token' => $seconds
                    ));

                    $participantTable->selectQuery("SELECT* FROM `tr_workshop_entry` WHERE `state`=? AND `token`=? ORDER BY `ID` DESC LIMIT 1", array($seconds));

                    if ($participantTable->count()) {
                        $participant_data = $participantTable->first();

                        $subject = '';

                        $messageText_0 = 'Dear <b>' . $participant_data->customer_firstname . '</b>,';

                        $messageText_1 = '';

                        $message_body = '';

                        $message_alt = $messageText_0 . ' ' . $messageText_1 . ' ' . $messageText_2;

                        $contactDetails['from_email'] = 'customerservice@toyotarwanda.com';
                        $contactDetails['from_names'] = 'Toyota Rwanda - Service';
                        $contactDetails['to_email'] = $participant_data->email;

                        $contactDetails['attach'] = false;

                        $email_status = Functions::smartMailer($contactDetails, $subject, $message_body, $message_alt);

                        // end EMAIL //
                        // REdirection To Next Page
                    }
                } catch (Exeption $e) {
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
                        'ERRORS_SCRIPT' => $validate->getErrorLocation()
            ];
        } else {
            return (object) [
                        'ERRORS' => false,
                        'SUCCESS' => true,
                        'ERRORS_SCRIPT' => ""
            ];
        }
    }

    public static function changeState($state, $entry_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $entry_ID;

        $seconds = \Config::get('time/seconds');

        $userTable = new WorkshopEntry();

        try {
            switch ($state) {
                case 'Delivered';
                    $userTable->update(array(
                        'status' => 'Delivered',
                        'delivered_date' => Dates::convTo('date', $seconds),
                        'delivered_time' => Dates::convTo('time', $seconds)
                            ), $ID);
                    break;
                case 'Completed';
                    $userTable->update(array(
                        'status' => 'Completed',
                        'completed_date' => Dates::convTo('date', $seconds),
                        'completed_time' => Dates::convTo('time', $seconds)
                            ), $ID);
                    break;
                case 'Progress';
                    $userTable->update(array(
                        'status' => 'Progress',
                        'starting_date' => Dates::convTo('date', $seconds),
                        'starting_time' => Dates::convTo('time', $seconds)
                            ), $ID);
                    break;
                case 'Pending';
                    $userTable->update(array(
                        'status' => 'Pending'
                            ), $ID);
                    break;
            }
        } catch (Exeption $e) {
            $diagnoArray[0] = "ERRORS_FOUND";
            $diagnoArray[] = $e->getMessage();
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

}
