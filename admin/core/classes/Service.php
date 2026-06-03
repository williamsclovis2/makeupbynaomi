<?php

class Service {

    private $_db,
            $_data,
            $_count = 0,
            $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // CREATE SERVICE
    public function insert($fields = array()) {
        if (!$this->_db->insert('services', $fields)) {
            throw new Exception("There was a problem creating the service.");
        }
        
        // Return the last inserted ID
        return $this->_db->lastInsertId();
    }

    // UPDATE SERVICE
    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('services', $id, $fields)) {
            throw new Exception('There was a problem updating the service.');
        }
    }

    // FIND SERVICE
    public function find($service_id = null) {
        if ($service_id) {
            $data = $this->_db->query("SELECT * FROM `services` WHERE `id` = ?", array($service_id));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // GET ALL SERVICES
    public function getAll($status = null) {
        if ($status !== null) {
            $data = $this->_db->query("SELECT * FROM `services` WHERE `status` = ? ORDER BY service_name ASC", array($status));
        } else {
            $data = $this->_db->query("SELECT * FROM `services` ORDER BY service_name ASC");
        }
        
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
            return true;
        }
        return false;
    }

    // GET ACTIVE SERVICES ONLY
    public function getActiveServices() {
        $data = $this->_db->query("SELECT * FROM `services` WHERE `status` = 'active' ORDER BY service_name ASC");
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
            return true;
        }
        return false;
    }

    // CHECK IF SERVICE NAME EXISTS
    public function serviceExists($service_name, $exclude_id = null) {
        if ($exclude_id) {
            $data = $this->_db->query("SELECT * FROM `services` WHERE `service_name` = ? AND `id` != ?", array($service_name, $exclude_id));
        } else {
            $data = $this->_db->query("SELECT * FROM `services` WHERE `service_name` = ?", array($service_name));
        }
        
        return $data->count() > 0;
    }

    // SELECT QUERY
    public function selectQuery($sql, $params = array()) {
        $data = $this->_db->query($sql, $params);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

    // DATA COLLECT
    public function data() {
        return $this->_data;
    }

    // FIRST
    public function first() {
        $data = $this->data();
        if (isset($data[0])) {
            return $data[0];
        }
        return '';
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