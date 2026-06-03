<?php

class NailEntry {

    private $_db,
            $_data,
            $_count = 0,
            $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // CREATE ENTRY
    public function insert($fields = array()) {
        if (!$this->_db->insert('entries', $fields)) {
            throw new Exception("There was a problem creating the entry.");
        }
        
        // Return the last inserted ID
        return $this->_db->lastInsertId();
    }

    // UPDATE ENTRY
    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('entries', $id, $fields)) {
            throw new Exception('There was a problem updating the entry.');
        }
    }

    // FIND ENTRY
    public function find($entry_id = null) {
        if ($entry_id) {
            $data = $this->_db->query("SELECT * FROM `entries` WHERE `id` = ?", array($entry_id));
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
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