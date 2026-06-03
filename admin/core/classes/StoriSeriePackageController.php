<?php

class StoriSeriePackageController {

    public static function edit($stori_serie_package_data) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $error_msg = '';

        $package_ID = $stori_serie_package_data->ID;

        $prfx = 'register-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SUBMIT[end($ar)] = $val;
            }
        }

        $str = new \Str();

        $validate = new Validate();
        $validation = $validate->check($_SUBMIT, array(
            'description' => array(
                'name' => 'Description',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $storiSeriePackage = new StoriSeriePackage();

            $description = @$_SUBMIT['description'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/stori/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'package_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
                    $file = $dir . 'thumb_' . $filename;

                    $featured_photo = FileManager::upload($_FILES["featuredImage"], $filename, "media_data/stori");
                } else {
                    $form_error = true;
                    Session::put('errors', "Featured photo File not supported");
                }
            } else {
                $featured_photo = $stori_serie_package_data->photo;
            }

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {

                try {
                    $storiSeriePackage->update(array(
                        'photo' => $featured_photo,
                        'description' => $description
                            ), $package_ID);

                    Session::put('success', 'The package has been edited successfully!');
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

    public static function add($form = 'Admin') {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $error_msg = '';

        $prfx = 'register-';
        foreach ($_POST as $index => $val) {
            $ar = explode($prfx, $index);
            if (count($ar)) {
                $_SUBMIT[end($ar)] = $val;
            }
        }

        $str = new \Str();

        $validate = new Validate();
        $validation = $validate->check($_SUBMIT, array(
            'code' => array(
                'name' => 'Code',
                'required' => true,
                'unique' => 'stori_package'
            ),
            'description' => array(
                'name' => 'Description',
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $storiSeriePackage = new StoriSeriePackage();

            $code = @$_SUBMIT['code'];
            $description = @$_SUBMIT['description'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/akazuba/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'package_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
                    $file = $dir . 'thumb_' . $filename;

                    $featured_photo = FileManager::upload($_FILES["featuredImage"], $filename, "media_data/stori");
                } else {
                    $form_error = true;
                    Session::put('errors', "Featured photo File not supported");
                }
            } else {
                $form_error = true;
            }

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {

                $pin_top = (int) self::getLastPin() + 1;

                try {
                    $storiSeriePackage->insert(array(
                        'photo' => $featured_photo,
                        'code' => $code,
                        'description' => $description,
                        'pin_top' => $pin_top
                    ));
                    Session::put('success', 'The package has been recorded successfully!');
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

    public static function changeState($status, $package_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $package_ID;

        $seconds = \Config::get('time/seconds');

        $storiSeriePackage = new StoriSeriePackage();

        $pin_top = (int) self::getLastPin() + 1;

        try {
            switch ($status) {
                case 'Published';
                    $storiSeriePackage->update(array(
                        'status' => 'Published',
                        'pin_top' => $pin_top
                            ), $ID);
                    break;
                case 'Deleted';

                    $storiSeriePackage = new StoriSeriePackage();
                    $storiSeriePackage->selectQuery("SELECT `code` FROM `stori_package` WHERE `ID`=? ", array($ID));
                    if ($storiSeriePackage->count()) {

                        $package_code = $storiSeriePackage->first()->code;
                        $storiSeriePackage = new StoriSeriePackage();

                        $storiSerie = new StoriSerie();
                        $storiSerie->selectQuery("SELECT `ID` FROM `stori_serie` WHERE `package`=? LIMIT 1", array($package_code));
                        if (!$storiSerie->count()) {
                            $storiSeriePackage->delete(array('ID', '=', $ID));
                            Session::put('success', 'Package deleted successfully');
                        } else {
                            Session::put('errors', 'This package cannot be deleted');
                        }
                    }


                    break;
            }
        } catch (Exception $e) {
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

    public static function pinOnTop($package_ID) {
        $pin_top = (int) self::getLastPin() + 1;

        $storiSeriePackage = new StoriSeriePackage();
        try {
            $storiSeriePackage->update(array(
                'pin_top' => $pin_top
                    ), $package_ID);
        } catch (Exception $e) {
            
        }
    }

    public static function getLastPin() {
        $storiSeriePackage = new StoriSeriePackage();
        $storiSeriePackage->selectQuery("SELECT `pin_top` FROM `stori_package` ORDER BY `pin_top` DESC LIMIT 1");
        $data = $storiSeriePackage->first();
        return $data->pin_top;
    }

}
