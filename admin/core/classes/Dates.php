<?php

// Global Time settings
$timezone = 'Africa/Khartoum';
$date = new DateTime('now', new DateTimeZone($timezone));
$date->sub(new DateInterval('P0Y0M0DT1H0M0S'));
$clone = clone $date;
$localtime = $date->format('h:i:s a');
$time = $date->format('U');

class Dates {

    public static function get($str, $sec = 0) {
        $timezone = 'Africa/Khartoum';
        $date = new DateTime('now', new DateTimeZone($timezone));
        $date->sub(new DateInterval('P0Y0M0DT1H0M0S'));
        $clone = clone $date;
        $localtime = $date->format('h:i:s a');
        $time = $date->format('U');
        $this_date = $clone;
        if ($sec != 0) {
            $this_sec = $sec - $time;
            $this_date->modify("$this_sec sec");
        }
        return $this_date->format($str);
    }

    public static function convTo($format, $time) {
        if ($format == 'date') {
            return dates('Y-m-d', $time);
        }
        if ($format == 'time') {
            return dates('H:i:s', $time);
        }
        if ($format == 'datetime') {
            return dates('Y-m-d H-i-s', $time);
        }
    }

    public static function timeLeft($format, $datetime1, $datetime2) {

        if (!is_numeric($datetime1)) {
            $datetime1 = strtotime($datetime1);
            $datetime2 = strtotime($datetime2);
        }

        $secs = $datetime2 - $datetime1; // == <seconds between the two times>
        $days = (int) ($secs / 86400);
        $hours = (int) ($secs / 3600);
        $mins = (int) ($secs / 60);

        if ($format == 'countDown') {
            if ($days > 0) {
                return $days . 'Days';
            } else {

                if ($hours > 0) {
                    return $hours . 'Hours';
                } else {
                    if ($mins > 0) {
                        return $mins . 'Minutes';
                    } else {
                        if ($secs > 0) {
                            return $secs . 'Seconds';
                        } else {
                            return 'Time out';
                        }
                    }
                }
            }
            if ($secs < 0) {
                return $days . 'D-' . $hours . 'H-' . $mins . 'M-' . $secs . 'S';
            } else {
                return '0D-0H-0M-0S';
            }
        }

        return false;
    }

    public static function strToSeconds($str, $format) {
        $dt = DateTime::createFromFormat($format, $str);
        $timestamp = $dt->format('U');
        return $timestamp;
    }

    public static function get_timeago($seconds) {
        $time = Config::get('time/seconds') - $seconds; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }

    public static function get_daylapsed($seconds, $deadline, $u) {

        $time = Config::get('time/seconds') - $seconds; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;

        if ($u == 'day') {
            $unit = 86400;
        }
        $numberOfUnits = (int) $deadline - floor($time / $unit);
        if ($numberOfUnits > 1) {
            return $numberOfUnits . ' ' . $u . 's';
        } elseif ($numberOfUnits < -1) {
            return $numberOfUnits . ' ' . $u . 's';
        } else {
            return $numberOfUnits . ' ' . $u;
        }
    }

    public static function get_time_ago_date($time, $until = null) {
        $temp = Config::get('time/seconds');
        if ($temp - $time < $until) {
            return '<span class="new">' . Dates::get_timeago($time) . '</span>';
        } else {
            return '<span class="old">' . dates('F d, Y', $time) . ' at ' . dates(' H:i A', $time) . '</span>';
        }
    }

    public static function get_en_date($time, $until = null) {
        return '<span class="old">' . dates('F, d Y', $time) . ' at ' . dates(' H:i A', $time) . '</span>';
    }

    public static function get_date_cord($cord, $time) {
        return dates($cord, $time);
    }

    public static function get_xml_date($time, $until = null) {
        return dates('D, d M Y', $time) . ' ' . dates(' H:i A', $time);
    }

    public static function dayName($n, $breif = false) {
        if ($n >= 1 && $n <= 7) {
            if ($breif) {
                $week_dayname_list = array('', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
            } else {
                $week_dayname_list = array('', 'Monday', 'Tueday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday');
            }
            return $week_dayname_list[$n];
        }
        return $week_dayname_list[1];
    }

}

?>