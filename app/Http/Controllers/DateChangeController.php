<?php

namespace App\Http\Controllers;

use App\Medecin;
use DateTime;
use Illuminate\Http\Request;

class DateChangeController extends Controller
{
    public static function date_created_at_to_string($date_created_at) {

        $date_fr = strftime("%A %d %B %G", strtotime($date_created_at));
        $date_fr = utf8_encode($date_fr);
        return $date_fr;
    }

}
