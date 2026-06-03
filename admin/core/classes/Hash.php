<?php

class Hash {

    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length) {
        return Hash::getRandomString($length);
    }

    public static function unique() {
        return self::make(uniqid());
    }

    public static function getRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    public static function encryptToken($data){
        return ($data * 353) ;
    }

    public static function decryptToken($data){
        return ($data ) / 353;
    }
}

?>