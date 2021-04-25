<?php


namespace libraries;


use DateTime;

class DateFunctions
{
    public function startOfDay($date){

        $time = new DateTime($date);

        $date = $time->format('d-m-Y');

        return $date;
    }

}