<?php

class WorkshopEntry {

    private $_db,
            $_data,
            $_count = 0,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn,
            $_errors = array();

    public function __construct($user = null) {
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if (!$user) {
            
        } else {
            
        }
    }

    //USER CREATE AN ACCOUNT
    public function insert($fields = array()) {
        if (!$this->_db->insert('tr_workshop_entry', $fields)) {
            throw new Exception("There was a problem creating a workshop entry account.");
        }
    }

// USER DATA UPDATE
    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('tr_workshop_entry', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

// USER DATA UPDATE
    public function recoverPassword($fields = array(), $id = null) {

        if (!$id && $this->isLoggedIn()) {
            $id = $this->data()->ID;
        } else {
            //Admin Of A group Came Update
        }

        if (!$this->_db->update('tr_workshop_entry', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

// FIND USER
    public function find($user = null) {
        if ($user) {
            $hit = false;
            if (is_numeric($user)) {
                $field = 'ID';
                $data = $this->_db->get('tr_workshop_entry', array($field, '=', $user));
                if ($data->count()) {
                    $this->_data = $data->first();
                    $hit = true;
                }
            } else {
                $subscriberClass = new WorkshopEntry();
                $subscriberClass->select("WHERE `token` = '{$user}' LIMIT 1");
                if ($subscriberClass->count()) {
                    $this->_data = $subscriberClass->first();
                    $hit = true;
                }
            }

            if ($hit == false) {
                if ($this->findUserByPhone($user)) {
                    return true;
                }
            } else {
                return true;
            }
        }
        return false;
    }

// FIND USER
    public function find_user($user = null, $fields = array()) {
        $table = "tr_workshop_entry";
        if ($user) {
            $hit = false;
            if (is_numeric($user)) {
                $field = 'ID';
                $data = $this->_db->get($fields, $table, array($field, '=', $user));
                if ($data->count()) {
                    $this->_data = $data->first();
                    $hit = true;
                }
            } else {
                $subscriberClass = new WorkshopEntry();
                $subscriberClass->select("WHERE `token` = '{$user}' LIMIT 1");
                if ($subscriberClass->count()) {
                    $this->_data = $subscriberClass->first();
                    $hit = true;
                }
            }

            if ($hit == true) {
                return true;
            }
        }
        return false;
    }

    // select	
    public function select($sql = null) {
        $data = $this->_db->query("SELECT* FROM `tr_workshop_entry` {$sql}");
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