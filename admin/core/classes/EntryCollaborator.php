<?php

class EntryCollaborator {

    private $_db,
            $_data,
            $_count = 0,
            $_errors = array();

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    // CREATE COLLABORATOR
    public function insert($fields = array()) {
        if (!$this->_db->insert('entry_collaborators', $fields)) {
            throw new Exception("There was a problem adding the collaborator.");
        }
    }

    // DELETE COLLABORATORS BY ENTRY
    public function deleteByEntry($entry_id) {
        $this->_db->query("DELETE FROM `entry_collaborators` WHERE `entry_id` = ?", array($entry_id));
    }

    // SELECT WITH PARAMS
    public function selectQuery($sql, $params = array()) {
        $data = $this->_db->query($sql, $params);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

    // DATA
    public function data() {
        return $this->_data;
    }

    // COUNT
    public function count() {
        return $this->_count;
    }
}

?>