<?php

class Customer {

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
    }

//USER CREATE AN ACCOUNT
    public function insert($fields = array()) {
        $fields['created_date'] = date('Y-m-d');
        if (!$this->_db->insert('customer', $fields)) {
            throw new Exception("There was a problem creating customer account.");
        }
    }

// USER DATA UPDATE
    public function update($fields = array(), $id = null) {


        if (!$this->_db->update('customer', $id, $fields)) {
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

        if (!$this->_db->update('customer', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

// FIND USER
    public function find($user = null, $limit = null) {
        if ($user) {
            $hit = false;
            if (is_numeric($user)) {
                $field = 'ID';
                $customerTable = new Customer();
                $customerTable->selectQuery("SELECT * FROM `customer` WHERE `$field`=? OR `telephone`='{$user}' ", array($user));

                if ($customerTable->count()) {
                    $this->_data = $customerTable->first();
                    $hit = true;
                }
            } else if (filter_var($user, FILTER_VALIDATE_EMAIL) == true) {
                $field = 'email';

                $customerTable = new Customer();
                $customerTable->selectQuery("SELECT * FROM `customer` WHERE `$field`=? ", array($user));

                if ($customerTable->count()) {
                    $this->_data = $customerTable->first();
                    $hit = true;
                }
            } else {
                $customerClass = new Customer();
                $customerClass->select("WHERE `username` ='{$user}' || `email` ='{$user}' || `telephone` ='{$user}'");
                if ($customerClass->count()) {
                    $this->_data = $customerClass->first();
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
    public function findUserByPhone($user = null) {
        if ($user) {
            $userClass = new Customer();
            $userClass->select("WHERE `telephone`='{$user}' LIMIT 1");
            if ($userClass->count()) {
                $this->_data = $userClass->first();
                return true;
            }
        }
        return false;
    }

    // select	
    public function select($sql = null) {
        $data = $this->_db->query("SELECT* FROM `customer` {$sql}");
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

// USER LOGIN
    public function login($username = null, $password = null, $remember = false) {
        $time = Config::get('time/timestamp');
        if (!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->ID);
            $userID = $this->data()->ID;

            $userTokenClass = new UserToken();
            $userTokenClass->select("WHERE `user_ID`='{$userID}' LIMIT 3");
            if (!$userTokenClass->count()) {
                $userTokenClass->insert(array('user_ID' => $userID));
            }
            $this->_db->query("UPDATE `customer` SET `last_login`='{$time}', `account_session`='1' WHERE `ID` = '{$this->data()->ID}'");
            $userID = $this->data()->ID;

            // reset online friend status
            Session::put('reset_online_list', true);
        } else {
            $user = $this->find($username, 1);
            if ($user) {

                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    if ($this->data()->groups != "Deleted" || $this->data()->groups != "Deactivated") {
                        //Session::put($this->_sessionName,$this->data()->ID);

                        $userID = $this->data()->ID;

                        Session::put('api_user_ID', $userID);

                        $this->_db->query("UPDATE `customer` SET `last_login`='{$time}' WHERE `ID` = '{$this->data()->ID}'");

                        // reset online friend status
                        return true;
                    }
                    $this->addError('Blocked account');
                    return 'Denied';
                } else {
                    $this->addError('Wrong Password');
                    return 'password';
                }
            } else {
                $this->addError('That email doesn\'t exist');
                return 'email';
            }
        }
        return false;
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


                $message = $body . ' || www.ferosmedia.com ||';
                $email_body = $message;

                //SENDING MESSAGE
                @mail($to, $subject, $email_body, $headers);
            }
        }
    }

// USER LOGOUT
    public function logout() {
        $sessionName = Config::get('session/session_name');
        $cookieName = Config::get('remember/cookie_name');
        if (Session::exists($sessionName)) {
            $user_ID = Session::get($this->_sessionName);
            $this->_db->delete('user_session', array('user_ID', '=', $user_ID));
            $this->update(array('account_session' => '0'));
            Session::delete($this->_sessionName);
            $userTokenClass = new UserToken();
            $userTokenClass->select("WHERE `user_ID`='{$user_ID}'");
            if ($userTokenClass->count()) {
                $usertoken_data = $userTokenClass->first();
                $userTokenClass->delete($usertoken_data->ID);
            }
        }
        Cookie::delete($this->_cookieName);
    }

// CHECK USER LOGGED IN
    public function isLoggedIn() {
        return $this->_isLoggedIn;
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