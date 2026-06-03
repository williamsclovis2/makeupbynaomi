<?php

class StoriSerieController {

    public static function edit($stori_serie_data) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $error_msg = '';

        $serie_ID = $stori_serie_data->ID;

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
            'serie_title' => array(
                'name' => 'Title',
                'required' => true
            ),
            'serie_description' => array(
                'name' => 'Description',
                'required' => true
            ),
            'package' => array(
                'name' => 'Package',
                'required' => true
            ),
            'package_type' => array(
                'name' => 'Package type',
                'required' => true
            ),
            'language' => array(
                'name' => 'Language'
            )
        ));

        if ($validation->passed()) {
            $categoryClass = new StoriSerie();

            $serie_title = @$_SUBMIT['serie_title'];
            $serie_description = @$_SUBMIT['serie_description'];
            $package_type = @$_SUBMIT['package_type'];
            $package = @$_SUBMIT['package'];
            $language = @$_SUBMIT['language'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/stori/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'serie_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
                    $file = $dir . 'thumb_' . $filename;

                    $featured_photo = FileManager::upload($_FILES["featuredImage"], $filename, "media_data/stori");
                } else {
                    $form_error = true;
                    Session::put('errors', "Featured photo File not supported");
                }
            } else {
                $featured_photo = $stori_serie_data->photo;
            }

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {

                try {
                    $categoryClass->update(array(
                        'photo' => $featured_photo,
                        'serie_title' => $serie_title,
                        'serie_description' => $serie_description,
                        'package_type' => $package_type,
                        'package' => $package,
                        'language' => $language
                            ), $serie_ID);

                    Session::put('success', 'The series has been edited successfully!');
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
            'serie_title' => array(
                'name' => 'Title',
                'required' => true
            ),
            'company_name' => array(
                'name' => "Nom de l'entreprise",
                'required' => true
            ),
            'job_type' => array(
                'name' => "Type d'emploi",
                'required' => true
            ),
             'comp_1' => array(
                'name' => 'Compétences 1',
                'required' => true
            ),
            'comp_2' => array(
                'name' => 'Compétences 2',
                'required' => true
            ),
            'comp_3' => array(
                'name' => 'Compétences 3',
                'required' => true
            ),
            'comp_4' => array(
                'name' => 'Compétences 4',
                'required' => true
            ),
            'comp_5' => array(
                'name' => 'Compétences 5',
                'required' => true
            ),
            'comp_6' => array(
                'name' => 'Compétences 6',
                'required' => true
            ),
            'comp_7' => array(
                'name' => 'Compétences 7',
                'required' => true
            ),
            'education' => array(
                'name' => 'Éducation',
                'required' => true
            ),
               'exp_1' => array(
                'name' => 'Expérience 1',
                'required' => true
            ),
            'exp_2' => array(
                'name' => 'Expérience 2',
                'required' => true
            ),
            'exp_3' => array(
                'name' => 'Expérience 3',
                'required' => true
            ),
            'exp_4' => array(
                'name' => 'Expérience 4',
                'required' => true
            ),
            'serie_description' => array(
                'name' => 'Description',
                'required' => true
            ),
            'dtserie_description' => array(
                'name' => 'Description détaillée'
            ),
            'package' => array(
                'name' => 'Package',
                'required' => true
            ),
            'package_type' => array(
                'name' => 'Package type',
                'required' => true
            ),
            'language' => array(
                'name' => 'Language'
            )
        ));

        if ($validation->passed()) {
            $categoryClass = new StoriSerie();

            $serie_title = @$_SUBMIT['serie_title'];
            $company_name        = @$_SUBMIT['company_name'];
            $job_type            = @$_SUBMIT['job_type'];
            $comp_1              = @$_SUBMIT['comp_1'];
            $comp_2              = @$_SUBMIT['comp_2'];
            $comp_3              = @$_SUBMIT['comp_3'];
            $comp_4              = @$_SUBMIT['comp_4'];
            $comp_5              = @$_SUBMIT['comp_5'];
            $comp_6              = @$_SUBMIT['comp_6'];
            $comp_7              = @$_SUBMIT['comp_7'];
            $education           = @$_SUBMIT['education'];
            $exp_1               = @$_SUBMIT['exp_1'];
            $exp_2               = @$_SUBMIT['exp_2'];
            $exp_3               = @$_SUBMIT['exp_3'];
            $exp_4               = @$_SUBMIT['exp_4'];
            $serie_description = @$_SUBMIT['serie_description'];
            $dtserie_description = @$_SUBMIT['dtserie_description'];
            $package_type = @$_SUBMIT['package_type'];
            $package = @$_SUBMIT['package'];
            $language = @$_SUBMIT['language'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/akazuba/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'serie_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
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
                    $categoryClass->insert(array(
                        'photo' => $featured_photo,
                        'serie_title' => $serie_title,
                        'company_name'        => $company_name,
                        'job_type'            => $job_type,
                        'comp_1'              => $comp_1,
                        'comp_2'              => $comp_2,
                        'comp_3'              => $comp_3,
                        'comp_4'              => $comp_4,
                        'comp_5'              => $comp_5,
                        'comp_6'              => $comp_6,
                        'comp_7'              => $comp_7,
                        'education'           => $education,
                        'exp_1'               => $exp_1,
                        'exp_2'               => $exp_2,
                        'exp_3'               => $exp_3,
                        'exp_4'               => $exp_4,
                        'serie_description' => $serie_description,
                        'dtserie_description' => $dtserie_description,
                        'package_type' => $package_type,
                        'package' => $package,
                        'pin_top' => $pin_top,
                        'language' => $language
                    ));
                    Session::put('success', 'The series has been recorded successfully!');
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

    public static function changeState($state, $serie_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $serie_ID;

        $seconds = \Config::get('time/seconds');

        $storiSerieTable = new StoriSerie();

        $pin_top = (int) self::getLastPin() + 1;

        try {
            switch ($state) {
                case 'Published';
                    $storiSerieTable->update(array(
                        'state' => 'Published',
                        'posting_date' => Dates::convTo('date', $seconds),
                        'posting_time' => Dates::convTo('time', $seconds),
                        'pin_top' => $pin_top
                            ), $ID);
                    break;
                case 'Pending';
                    $storiSerieTable->update(array(
                        'state' => 'Pending'
                            ), $ID);
                    break;
                case 'Deleted';
                    $storiSerieTable->update(array(
                        'state' => 'Deleted'
                            ), $ID);
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

    public static function addView($serie_ID) {

        $storiSerieTable = new StoriSerie();
        $storiSerieTable->selectQuery("SELECT `views` FROM `stori_serie` WHERE `ID`=?", array($serie_ID));

        if ($storiSerieTable->count()) {
            $stori_serie_data = $storiSerieTable->first();
            $new_view = $stori_serie_data->views + 1;
            $seconds = \Config::get('time/seconds');
            try {

                $storiSerieTable->update(array(
                    'views' => $new_view,
                    'last_view_date' => Dates::convTo('date', $seconds),
                    'last_view_time' => Dates::convTo('time', $seconds)
                        ), $serie_ID);
            } catch (Exception $e) {
                
            }
        }
    }

    public static function pinOnTop($serie_ID) {
        $pin_top = (int) self::getLastPin() + 1;

        $storiSerieTable = new StoriSerie();
        try {
            $storiSerieTable->update(array(
                'pin_top' => $pin_top
                    ), $serie_ID);
        } catch (Exception $e) {
            
        }
    }

    public static function getLastPin() {
        $storiSerieTable = new StoriSerie();
        $storiSerieTable->selectQuery("SELECT `pin_top` FROM `stori_serie` ORDER BY `pin_top` DESC LIMIT 1");
        $data = $storiSerieTable->first();
        return $data->pin_top;
    }

}
