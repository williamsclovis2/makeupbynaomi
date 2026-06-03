<?php

class SubscribeAndroid {

    private $_db,
            $_data,
            $_subscribe_ID,
            $_userID,
            $_count = 0,
            $_errors = false;

    public function __construct($subscribe_ID = null) {
        $this->_db = DB::getInstance();

        if ($subscribe_ID) {
            $this->_subscribe_ID = $subscribe_ID;
            $this->get($subscribe_ID);
        }
    }

//article
    public function insert($fields = array()) {
        if (!$this->_db->insert('subscribe_android', $fields)) {
            return false;
        }
        return true;
    }

// select
    public function select($sql = null, $vals = array()) {
        $data = $this->_db->query("SELECT* FROM `subscribe_android` {$sql}", $vals);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

    // select	
    public function selectQuery($sql = null, $vals = array()) {
        $data = $this->_db->query($sql, $vals);
        if ($data->count()) {
            $this->_count = $data->count();
            $this->_data = $data->results();
        }
    }

// Log Access
    public function logAccess($token_ID) {

        $temp = Config::get('time/seconds');
        if ($this->_db->query("UPDATE `subscribe_android` SET `online_date`='{$temp}' WHERE `token_ID`= ?", array($token_ID))) {
            return false;
        }
        return true;
    }

// Unsub
    public function unsubscribe($email) {
        $this->_db->query("UPDATE `subscribe_android` SET `state`='Deactivated' WHERE `token_ID`=?", array($token_ID));
    }

//Delete
    public function delete($id) {
        $this->get($id);
        $this->_db->delete('subscribe_android', array('ID', '=', $id));
    }

//Send notif
    public function sendNotif($title, $body, $tag = "") {
        $jumb_articles_sql = "";
        $subscribeClass = new SubscribeAndroid();
        $subscribeClass->select("ORDER BY `online_date` DESC LIMIT 1000");
        $temp = Config::get('time/seconds');

        $ids = array();

        if ($subscribeClass->count()) {
            foreach ($subscribeClass->data() as $subscribe_data) {
                $ids[] = $subscribe_data->token_ID;
            }
        }

        define('API_ACCESS_KEY', 'AAAAQ6zDWcg:APA91bFbUX6f364Y8IGI_tOWZKsaNqgkejaLEMZpCGweQZc3K12k83P4EmupIHloCmQDzSrUEcVn44RTonYF46Qkmroypy7rkyGA-heiBVCbz8FLhwD4mIIGq2d-UVVIb06CNHdLWSWa');

        $registrationIds = $ids;

        // prep the bundle
        $msg = array
            (
            'title' => $title,
            'icon' => 'myicon',
            'sound' => 'default',
            'tag' => 'News',
            'color' => '#002ba8e0',
            'body' => $body
        );
        $fields = array
            (
            'registration_ids' => $ids,
            'notification' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
//        if($result === false)
//                die('Curl failed ' . curl_error());
        curl_close($ch);
//        echo $result;
    }

// data	
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

// count	
    public function count() {
        return $this->_count;
    }

}
