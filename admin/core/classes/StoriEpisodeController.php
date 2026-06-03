<?php

class StoriEpisodeController {

    public static function edit($stori_episode_data) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();
        $error_msg = '';
        $episode_ID = $stori_episode_data->ID;

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
            'episode_title' => array(
                'name' => 'Title',
                'required' => true
            ),
            'episode_description' => array(
                'name' => 'Description'
            )
        ));

        if ($validation->passed()) {
            $categoryClass = new StoriEpisode();

            $episode_title = @$_SUBMIT['episode_title'];
            $episode_description = @$_SUBMIT['episode_description'];


            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/stori/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'episode_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
                    $file = $dir . 'thumb_' . $filename;

                    $featured_photo = FileManager::upload($_FILES["featuredImage"], $filename, "media_data/stori");
                } else {
                    $form_error = true;
                    Session::put('errors', "Featured photo File not supported");
                }
            } else {
                $featured_photo = $stori_episode_data->photo;
            }

            $seconds = \Config::get('time/seconds');

            if ($diagnoArray[0] == 'NO_ERRORS') {

                try {
                    $categoryClass->update(array(
                        'photo' => $featured_photo,
                        'episode_title' => $episode_title,
                        'episode_description' => $episode_description
                            ), $episode_ID);
                    Session::put('success', 'The resource has been edited successfully!');
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

    public static function add($serie_ID) {
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
            'episode_title' => array(
                'name' => 'Title',
                'required' => true
            ),
            'episode_description' => array(
                'name' => 'Description'
            )
        ));

        if ($validation->passed()) {
            $categoryClass = new StoriEpisode();

            $episode_title = @$_SUBMIT['episode_title'];
            $episode_description = @$_SUBMIT['episode_description'];

            $temp = Config::get('time/temp');

            $featured_photo = '';

            if (isset($_FILES['featuredImage']['name']) && !empty($_FILES['featuredImage']['name'])) {

                $_FILES['featuredImage']['type'] = strtolower($_FILES['featuredImage']['type']);
                $dir = 'media_data/akazuba/';

                if ($_FILES['featuredImage']['type'] == 'image/png' || $_FILES['featuredImage']['type'] == 'image/jpg' || $_FILES['featuredImage']['type'] == 'image/gif' || $_FILES['featuredImage']['type'] == 'image/jpeg' || $_FILES['featuredImage']['type'] == 'image/pjpeg') {
                    // setting file's mysterious name
                    $filename = 'episode_' . substr(md5(date('YmdHis')), -5, 5) . '.jpg';
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
                        'photo' => $featured_photo,
                        'episode_title' => $episode_title,
                        'episode_description' => $episode_description
                    ));
                    Session::put('success', 'The resource has been recorded successfully!');
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

    public static function changeState($state, $episode_ID) {
        $diagnoArray[0] = 'NO_ERRORS';
        $validate = new \Validate();

        $ID = $episode_ID;

        $seconds = \Config::get('time/seconds');

        $storiEpisodeTable = new StoriEpisode();

        try {
            switch ($state) {
                case 'Published';
                    $storiEpisodeTable->update(array(
                        'state' => 'Published',
                        'posting_date' => Dates::convTo('date', $seconds),
                        'posting_time' => Dates::convTo('time', $seconds)
                            ), $ID);
                    break;
                case 'Pending';
                    $storiEpisodeTable->update(array(
                        'state' => 'Pending'
                            ), $ID);
                    break;
                case 'Deleted';
                    $storiEpisodeTable->update(array(
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

    public static function addView($episode_ID) {

        $storiEpisodeTable = new StoriEpisode();
        $storiEpisodeTable->selectQuery("SELECT * FROM `stori_episode` WHERE `ID`=?", array($episode_ID));

        if ($storiEpisodeTable->count()) {
            $stori_episode_data = $storiEpisodeTable->first();
            $new_view = $stori_episode_data->views + 1;
            $seconds = \Config::get('time/seconds');
            try {

                $storiEpisodeTable->update(array(
                    'views' => $new_view,
                    'last_view_date' => Dates::convTo('date', $seconds),
                    'last_view_time' => Dates::convTo('time', $seconds)
                        ), $episode_ID);
            } catch (Exeption $e) {
                
            }
        }
    }

    public static function addViewFull($episode_ID) {

        $storiEpisodeTable = new StoriEpisode();
        $storiEpisodeTable->selectQuery("SELECT * FROM `stori_episode` WHERE `ID`=?", array($episode_ID));

        if ($storiEpisodeTable->count()) {
            $stori_episode_data = $storiEpisodeTable->first();
            $new_view = $stori_episode_data->views_full + 1;
            $seconds = \Config::get('time/seconds');
            try {

                $storiEpisodeTable->update(array(
                    'views_full' => $new_view,
                    'last_view_date' => Dates::convTo('date', $seconds),
                    'last_view_time' => Dates::convTo('time', $seconds)
                        ), $episode_ID);
            } catch (Exeption $e) {
                
            }
        }
    }

}
