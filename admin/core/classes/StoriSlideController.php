<?php

class StoriSlideController {

    public static function edit($stori_slide_data) {
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
            'slide_title' => array(
                'name' => 'Title'
            )
        ));

        if ($validation->passed()) {


            $categoryClass = new StoriSlide();

            $slide_title = @$_SUBMIT['slide_title'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/akazuba/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'slide_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
                    $file = $dir . 'thumb_' . $filename;

                    $featured_photo = FileManager::upload($_FILES["featuredImage"], $filename, "media_data/stori");
                } else {
                    $form_error = true;
                    Session::put('errors', "Slide photo File not found or not supported");
                }
            } else {
                $form_error = true;
            }

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {



                try {
                    $categoryClass->update(array(
                        'photo' => $featured_photo
                            ), $stori_slide_data->ID);
                    Session::put('success', 'The slide has been recorded successfully!');
                } catch (Exeption $e) {
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

    public static function add($episode_ID) {


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
            'slide_title' => array(
                'name' => 'Title'
            )
        ));

        if ($validation->passed()) {

            $episodeClass = new StoriEpisode();

            $episodeClass->find($episode_ID);

            $episode_data = $episodeClass->data();

            $serie_ID = $episode_data->serie_ID;

            $categoryClass = new StoriSlide();

            $slide_title = @$_SUBMIT['slide_title'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/akazuba/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'slide_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
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

                try {
                    $categoryClass->insert(array(
                        'serie_ID' => $serie_ID,
                        'episode_ID' => $episode_ID,
                        'photo' => $featured_photo
                    ));
                    Session::put('success', 'The slides has been recorded successfully!');
                } catch (Exeption $e) {
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

    public static function changeState($state, $slide_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $slide_ID;

        $seconds = \Config::get('time/seconds');

        $storiSlideTable = new StoriSlide();

        try {
            switch ($state) {
                case 'Published';
                    $storiSlideTable->update(array(
                        'state' => 'Published',
                        'posting_date' => Dates::convTo('date', $seconds),
                        'posting_time' => Dates::convTo('time', $seconds)
                            ), $ID);
                    break;
                case 'Pending';
                    $storiSlideTable->update(array(
                        'state' => 'Pending'
                            ), $ID);
                    break;
                case 'Deleted';
                    $storiSlideTable->update(array(
                        'state' => 'Deleted'
                            ), $ID);
                    break;
            }
        } catch (Exeption $e) {
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

    public static function addView($slide_ID) {

        $storiSlideTable = new StoriSlide();
        $storiSlideTable->selectQuery("SELECT * FROM `stori_slide` WHERE `ID`=?", array($slide_ID));

        if ($storiSlideTable->count()) {
            $stori_slide_data = $storiSlideTable->first();
            $new_view = $stori_slide_data->views + 1;
            $seconds = \Config::get('time/seconds');
            try {

                $storiSlideTable->update(array(
                    'views' => $new_view,
                    'last_view_date' => Dates::convTo('date', $seconds),
                    'last_view_time' => Dates::convTo('time', $seconds)
                        ), $slide_ID);
            } catch (Exeption $e) {
                
            }
        }
    }

}
