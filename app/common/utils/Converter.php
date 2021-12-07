<?php

class Converter
{
    public static function secondsToHours($time){

        $hours = $time/3600;

        if($time % 3600 != 0 ){
            $minutes = $time % 3600 / 60;
        }

        if($time % 60 != 0){
            $seconds = $time % 60;
        }

        $hours = number_format($hours , 2);
        $minutes = number_format($minutes, 2);
        $seconds = number_format($seconds, 2);

        $string = $hours.':'.$minutes.':'.$seconds.' h';

        return $string;
    }
}