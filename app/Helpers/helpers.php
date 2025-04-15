<?php

use Carbon\Carbon;

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd-m-Y') {
        if (empty($date)) return null;

        try {
            return Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return $date;
        }
    }
}


if (!function_exists('format_datetime')) {
    function format_datetime($dateTime, $format = 'd-m-Y H:i') {
        if (empty($dateTime)) return null;

        try {
            return Carbon::parse($dateTime)->format($format);
        } catch (\Exception $e) {
            return $dateTime;
        }
    }
}