<?php

class StoriSubscription {

    private $_db,
            $_data,
            $_count = 0,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn,
            $_errors = array();

    public function __construct($user = null) {
        $this->_db = DB::getInstance();
    }

//USER CREATE AN ACCOUNT
    public function insert($fields = array()) {
        $latest_update_date = date('Y-m-d');
        $fields['latest_update_date'] = $latest_update_date;
        if (!$this->_db->insert('stori_subscription', $fields)) {
            throw new Exception("There was a problem record subscription.");
        }
    }

// USER DATA UPDATE
    public function update($fields = array(), $id='') {
        $latest_update_date = date('Y-m-d');
        $fields['latest_update_date'] = $latest_update_date;
        if (!$this->_db->update('stori_subscription', $id, $fields)) {
            throw new Exception('There was a problem updating subscription: FIELDS' . print_r($fields, 1) . " ID:" . $id);
        }
    }

// FIND USER
    public function find($user = null, $limit = null) {
        if ($user) {
            $hit = false;
            if (is_numeric($user)) {
                $field = 'ID';
                $storiSubscriptionTable = new StoriSubscription();
                $storiSubscriptionTable->selectQuery("SELECT * FROM `stori_subscription` WHERE `$field`=? ", array($user));

                if ($storiSubscriptionTable->count()) {
                    $this->_data = $storiSubscriptionTable->first();
                    $hit = true;
                }
            }

            if ($hit == false) {
                return true;
            } else {
                return true;
            }
        }
        return false;
    }

    // select	
    public function select($sql = null) {
        $data = $this->_db->query("SELECT* FROM `stori_subscription` {$sql}");
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

    // Select	
    public function selectQuery($sql, $params = array()) {
        $data = $this->_db->query($sql, $params);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    // SENDING EMAIL
    public function emailTo($from, $to, $subject = '', $body = '', $headers = '') {
        if (Validate::valEmail($from) === true) {
            if (Validate::valEmail($to) === true) {
                $fname = '';
                $lname = '';
                if ($this->find($from) == true) {
                    $user_data = $this->data();
                    $fname = $user_data->firstname;
                    $lname = $user_data->lastname;
                }
                if ($this->find($to) == true) {
                    $user_data_to = $this->data();
                    $fname_to = $user_data_to->firstname;
                    $lname_to = $user_data_to->lastname;
                }


                $message = $body . ' || www.storiafrica.com ||';
                $email_body = $message;

                //SENDING MESSAGE
                @mail($to, $subject, $email_body, $headers);
            }
        }
    }

// DATA COLLECT
    public function data() {
        return $this->_data;
    }

// first
    public function first() {
        $data = $this->data();
        if (isset($data[0])) {
            return $data[0];
        }
        return '';
    }

// DATA COUNT
    public function count() {
        return $this->_count;
    }

// ADD ERRORS NOTIF
    private function addError($error) {
        $this->_errors[] = $error;
    }

// ERROR COLLECT
    public function errors() {
        return $this->_errors;
    }

}

?> 