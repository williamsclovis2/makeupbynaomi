<?php

class Functions {

    public static function json_enc($str) {
        return json_encode($str, true);
    }

    public static function json_dec($str) {
        return json_decode($str, true);
    }

    public static function print_time_($dt_retr_date) {
        $cur_retr_date = Config::get('time/date_time');
        $cur_plit_date = substr($cur_retr_date, 5, 10);
        $cur_time = substr($cur_retr_date, 16, 11);
        $cur_day = substr($cur_retr_date, 0, 3);

        $dt_plit_date = substr($dt_retr_date, 5, 10);
        $dt_time = substr($dt_retr_date, 16, 11);
        $dt_day = substr($dt_retr_date, 0, 3);

        if ($dt_plit_date === $cur_plit_date) {
            return '<value title="' . $dt_retr_date . '" style="cursor: pointer">' . 'at ' . $dt_time . '</value>';
        }
        if ($dt_plit_date < $cur_plit_date) {
            return '<value title="' . $dt_retr_date . '" style="cursor: pointer">' . 'on ' . $dt_day . ' ' . $dt_plit_date . '</value>';
        }
        return $dt_retr_date;
    }

    public static function time_past($ref_sec) {
        $cur_sec = Config::get('time/timestamp');
        $band = ($cur_sec - $ref_sec) / 60;
        $split = explode('.', $band);
        $min = $split[0];
        $sec = $cur_sec - $ref_sec;
        if ($band < 1) {
            return '<value style="cursor: pointer">' . $sec . 'sec ago </value>';
        } elseif ($min < 60) {
            return '<value style="cursor: pointer">' . $min . 'min ago </value>';
        } else {
            $band1 = $min / 60;
            $split1 = explode('.', $band1);
            $hour = $split1[0];
            if ($hour < 24) {
                return '<value style="cursor: pointer">' . $hour . 'h ago </value>';
            } else {
                $band2 = $hour / 24;
                $split2 = explode('.', $band2);
                $day = $split2[0];
                if ($day < 7) {
                    return '<value style="cursor: pointer">' . $day . 'd ago </value>';
                } else {
                    return '<value style="cursor: pointer">' . $day . 'd ago </value>';
                }
            }
        }
    }

    public static function get_timeago($ptime) {
        $temp = Config::get('time/temp');
        $estimate_time = (double) $temp - (double) $ptime;

        if ($estimate_time < 1) {
            return ' < 1 sec ago';
        }

        $condition = array(
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;

            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . $str . ( $r > 1 ? 's' : '' );
            }
        }
    }

    public static function print_F_size($ref_size) {
        $size_K = $ref_size / 1000;
        if ($ref_size < 1000) {
            return '<value style="cursor: pointer">' . $ref_size . ' B </value>';
        } elseif ($ref_size < 1000000) {
            return '<value style="cursor: pointer">' . (int) ($ref_size / 1000) . 'Kb </value>';
        } elseif ($ref_size < 1000000000) {
            return '<value style="cursor: pointer">' . (int) ($ref_size / 1000000) . 'Mb </value>';
        } elseif ($ref_size < 1000000000000) {
            return '<value style="cursor: pointer">' . (int) ($ref_size / 1000000) . 'Gb </value>';
        }
    }

    public static function getFileIcon($anyfile) {
        if ($anyfile == 1) {
            return 'icon/file_type/img.png';
        } else {
            return 'icon/file_type/file1.png';
        }
    }

    
public static function flashMsg() {
    ?>
    <?php
    // Success Message
    if (Session::exists('success')) {
        $session_success = Session::get('success');
        if (!empty($session_success)) {
            // Flash (consume) the session AFTER getting the value
            Session::delete('success');
            ?>
            <script>
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '<?php echo addslashes($session_success); ?>',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: 'top-end',
                        toast: true
                    });
                } else {
                    console.error('SweetAlert2 is NOT loaded!');
                    alert('<?php echo addslashes($session_success); ?>');
                }
            </script>
            <?php
        }
    }
    ?>

    <?php
    // Error Message
    if (Session::exists('errors')) {
        $session_errors = Session::get('errors');
        if (!empty($session_errors)) {
            Session::delete('errors');
            ?>
            <script>
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: '<?php echo addslashes($session_errors); ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    alert('<?php echo addslashes($session_errors); ?>');
                }
            </script>
            <?php
        }
    }
    ?>
    <?php
}

    public static function sendEmail($user_ID, $from, $to, $subject, $headers, $messageText, $heading) {
        $message = '
			<html>
				<body>
					<header style="background-color: #1c77ba; background-size: 100%; padding: 5px; border-radius: 10px; position: relative; margin-left: 10px; margin-right: 10px">
						<span class="position: absolute; left: 200px; bottom: 10px;"><em style=" color: #ddd;">g</em></span>
					</header>
					<div  style="border: 1px solid #dddddd; border-radius: 10px 10px 0px 0px;  padding: 10px; margin-left: 10px; margin-right: 10px">
						
						<section style="border-bottom: 10px solid #1c77ba; padding-bottom: 20px;">
							<header>
								<h2 style="border-bottom: 10px solid #1c77ba; color: #666666;"> ' . $subject . ' </h2>
							</header>
							<article style="border: 1px solid #dddddd; border-radius: 5px; padding: 5px 10px; background: #ffffff; margin: 5px 10px;">
								<header>
									<h4 style="padding: 2px 0px; margin: 5px 0px; font-size: 15px; font-weight: 600;"> ' . $heading . ' </h4>
								</header>
								<p>
									' . $messageText . '
								</p>
							</article>
						</section>
						<footer style="background: #eeeeee; font-size: 13px; padding: 5px; color: #666666;">
							<div style="clear: both"></div>
						</footer>
					</div>
				</body>
			</html>
			';
        if (@mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendEmailToSub($from, $to, $subject, $headers, $messageText, $heading, $logo) {
        $message = '
			<html>
				<body style="font-family: helvetica;">
					<header style="background-color: #1c77ba; background-size: 100%; padding: 5px; border-radius: 0px; position: relative; margin-left: 10px; margin-right: 10px">
						<span class="position: absolute; bottom: 10px;"><em style=" color: #eeeeee;"></em></span>
					</header>
					<div style="padding: 10px; margin-left: 10px; margin-right: 10px">
						
						<section style="border-bottom: 8px solid #1c77ba; padding-bottom: 10px;">
							<header style="position: relative"> 
                                ' . $heading . '
							</header>
							<article style=" border: 1px solid #dddddd; border-radius: 0px; padding: 5px 10px; background: #ffffff; margin: 10px 20px 5px 20px;">
								<p>
									' . $messageText . '
								</p>
							</article>
						</section>
						<div style="font-size: 12px; padding: 0px; color: #666666; position: relative">
                            <br>
							<!--<center><img src="' . $logo . '" style="width: auto; height: 100px"></center>-->
                            <br>
                            <div style="background: #fff;text-align: left; color: #999; border-top: 1px solid #ddd; padding: 10px 5px">
                                Stori Africa | support@storiafrica.com 
                            </div>
						</div>
					</div>
				</body>
			</html>
			';
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

    public static function smartMailer($contactDetails, $subject, $message_body, $message_alt) {

        $from_email = @$contactDetails['from_email'];
        $from_names = @$contactDetails['from_names'];
        $to_email = @$contactDetails['to_email'];
        $cc_email = @$contactDetails['cc_email'];
        $cc_email_1 = @$contactDetails['cc_email_1'];
        $message_attach = @$contactDetails['attach'];

        try {
            $mail = new PHPMailer(true); //New instance, with exceptions enabled

            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
                        <html>
                          <head>
                            <title>Stori Africa</title>
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                          </head>
                          ' . $message_body . '
                        </html>
                    ';

            $body = preg_replace('/\\\\/', '', $body); //Strip backslashes

            $mail->IsSMTP();                           // tell the class to use SMTP
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;                   // enable SMTP authentication

            if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1') {

                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host = "storiafrica.com";
                $mail->Port = 465; // or 587
                $mail->Username = "support@storiafrica.com";
                $mail->Password = "Stori@123456";
            } else {
                $mail->IsSendmail();
            }

            $mail->AddReplyTo($from_email, $from_names);

            $mail->From = $from_email;
            $mail->FromName = $from_names;

            $mail->AddAddress($to_email);

            if ($cc_email) {
                $mail->AddCC($cc_email);
            }
            if ($cc_email_1) {
                $mail->AddCC($cc_email_1);
            }

            $mail->Subject = $subject;

            if ($message_attach != false) {
                $mail->AddAttachment($message_attach); // attachment
            }

            $mail->AltBody = $message_alt; // optional, comment out and test
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($body);

            $mail->IsHTML(true); // send as HTML

            $mail->Send();

            return true;
        } catch (phpmailerException $e) {
            return $e->errorMessage();
        }
    }

    public static function passPrice($categ, $currency) {

        $str = 'Apr 10 2017';
        $format = 'F d Y';
        $dt = DateTime::createFromFormat($format, $str);
        $timestamp = $dt->format('U');
        $cur_sec = Config::get('time/seconds');
        if ($cur_sec > $timestamp) {
            $early_bird = false;
        } else {
            $early_bird = true;
        }
        $amount = 0;
        switch ($categ) {
            case 'Silver':
            case 'Silver-discounted':

            case 'Individual-Silver':
            case 'Group-Silver':

            case 'Individual-Silver-Discounted':
            case 'Group-Silver-Discounted':
            case 'Exhibitor-Silver-Discounted':
            case 'Sponsor-Silver-Discounted':
            case 'Smart-Africa-Member-Silver-Discounted':
            case 'Face-the-Gorillas-Silver-Discounted':
            case 'Ms-Geek-2017-Silver-Discounted':
                if ($currency == "Local") {
                    if ($early_bird) {
                        $amount = 125000;
                        // $amount = 100;
                    } else {
                        $amount = 170000;
                    }
                } else {
                    if ($early_bird) {
                        $amount = 150;
                        // $amount = 1;
                    } else {
                        $amount = 200;
                    }
                }
                break;
            case 'Gold':
            case 'Gold-discounted':

            case 'Individual-Gold':
            case 'Group-Gold':
            case 'Individual-Gold-Discounted':
            case 'Group-Gold-Discounted':
            case 'Exhibitor-Gold-Discounted':
            case 'Sponsor-Gold-Discounted':
            case 'Face-the-Gorillas-Gold-Discounted':
            case 'Smart-Africa-Member-Gold-Discounted':
            case 'Ms-Geek-2017-Gold-Discounted':
                if ($currency == "Local") {
                    if ($early_bird) {
                        $amount = 290000;
                    } else {
                        $amount = 425000;
                    }
                } else {
                    if ($early_bird) {
                        $amount = 350;
                    } else {
                        $amount = 500;
                    }
                }
                break;
            case 'Platinum':
            case 'Platinum-discounted':

            case 'Individual-Platinum':
            case 'Group-Platinum':
            case 'Individual-Platinum-Discounted':
            case 'Group-Platinum-Discounted':
            case 'Exhibitor-Platinum-Discounted':
            case 'Sponsor-Platinum-Discounted':
            case 'Smart-Africa-Member-Platinum-Discounted':
            case 'Face-the-Gorillas-Platinum-Discounted':
            case 'Ms-Geek-2017-Platinum-Discounted':
                if ($currency == "Local") {
                    $amount = 635000;
                } else {
                    $amount = 750;
                }
                break;
            case 'Standard':
                if ($currency == "Local") {
                    $amount = 3400000;
                } else {
                    $amount = 4000;
                }
                break;
            case 'Premium':
                if ($currency == "Local") {
                    $amount = 6375000;
                } else {
                    $amount = 7500;
                }
                break;
        }
        return $amount;
    }

    public static function makeCapcha($fieldname) {
        $capcha = substr(md5(rand(1000, 9999)), 0, 4);
        ?>
        <div style="height:30px; width: 100%; overflow: hidden; position: relative; background: #fff">
            <span style="top: 3px; width: 100%; text-align: center;position: absolute; font-size: 20px; font-weight: 700; font-family: 'Roboto-Bold'; color: #000"><?= $capcha ?></span>
            <img src="<?= DN ?>/img/capcha.png" style="opacity: .3; margin-top: -<?= rand(50, 120) ?>px; margin-left: <?= rand(-200, 0) ?>px;">
        </div>
        <input type="hidden" name="<?= $fieldname ?>" value="<?= $capcha ?>" style="width: 0px; height: 0px">
        <?php
    }

    public static function getJobTitles($errorstate, $value = '', $categ = '') {
        ?>

        <option value=""> [--Select--] </option>
        <option value="Babysiting" <?php
        if ($errorstate && $value == 'Babysiting') {
            echo 'selected="selected"';
        }
        ?>>Babysiting</option>

        <option value="Housework" <?php
        if ($errorstate && $value == 'Housework') {
            echo 'selected="selected"';
        }
        ?>>Housework</option>

        <option value="Other" <?php
        if ($errorstate && $value == 'Other') {
            echo 'selected="selected"';
        }
        ?>>Other </option>
        <?php
    }

    public static function errorPage($number) {
        if ($number == 404) {
            include 'views/errors/404' . P;
        } else {
            include 'views/errors/404' . P;
        }
        echo '<div class="clearfix"></div>';
    }

    public static function getStateCol($state) {
        switch ($state) {
            case 'Activate':
            case 'Activated':
                return '#4093D0';
                break;
            case 'Attend':
            case 'Attended':
                return '#00a65a';
                break;
            case 'Pending':
                return 'orange';
                break;
            case 'Deactivate':
            case 'Deactivated':
                return '#999';
                break;
        }
    }

    public static function getUserIP() {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public static function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode,
                            "latitude" => @$ipdat->geoplugin_latitude,
                            "longitude" => @$ipdat->geoplugin_longitude,
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                    case "latitude":
                        $output = @$ipdat->geoplugin_latitude;
                        break;
                    case "longitude":
                        $output = @$ipdat->geoplugin_longitude;
                        break;
                }
            }
        }
        return $output;
    }

    public static function generateStrongPassword($length = 6, $add_dashes = false, $available_sets = 'luds') {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public static function actualisePaymentStatus() {

        $data_array = array(
            "request" => 'customer-refresh_payments_status'
        );

        $api_url = DNADMIN . "/mobile-api-raisin-mtn-request";

        $result = Functions::callPostAPI($api_url, $data_array);
        return $result;
    }

    public static function callPostAPI($url, $postfields) {

        //define the end point url and api key
        $api_key = "ABC123";

        //urlify the data for the POST
        $fields_string = http_build_query($postfields);

        //prepare curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$api_key]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, count($postfields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //needed for https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //make the request
        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    public static function discount($amount_gross, $discount) {
        return $amount_gross - $amount_gross * $discount / 100;
    }

}
?>