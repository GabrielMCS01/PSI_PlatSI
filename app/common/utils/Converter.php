<?php

namespace common\utils;

class Converter
{
    public static function timeConverter($time){

        $hours = intval($time/3600 ,10 );

        $minutes = 0;
        $seconds = 0;

        if($time % 3600 != 0 ){
            $minutes = intval($time % 3600 / 60, 10);
        }

        if($time % 60 != 0){
            $seconds = $time % 60;
        }



        $string = sprintf('%02d',$hours).':'. sprintf('%02d',$minutes).':'. sprintf('%02d',$seconds).' h';

        return $string;
    }


    public static function distanceConverter($distance){

        $distance = $distance / 1000;

        $string = sprintf('%01.2f',$distance) . ' Km';

        return $string;
    }

    public static function velocityConverter($velocity){

        $string = sprintf('%01.2f',$velocity) . ' Km/h';

        return $string;
    }
}