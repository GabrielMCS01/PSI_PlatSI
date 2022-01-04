<?php

namespace common\utils;

class Converter
{
    // Conversor de tempo
    public static function timeConverter($time){
        // Converte o tempo total para horas
        $hours = intval($time/3600 ,10 );

        $minutes = 0;
        $seconds = 0;

        // Se houver resto de 3600 faz
        if($time % 3600 != 0 ){
            // Converte o resto para minutos
            $minutes = intval($time % 3600 / 60, 10);
        }

        // Se houver resto de 60 faz
        if($time % 60 != 0){
            // Converte o resto para segundos
            $seconds = $time % 60;
        }

        // Constroi uma String com as Horas, minutos e segundos
        $string = sprintf('%02d',$hours).':'. sprintf('%02d',$minutes).':'. sprintf('%02d',$seconds).' h';

        return $string;
    }

    // Converte a distância para kilometros
    public static function distanceConverter($distance){

        $distance = $distance / 1000;

        $string = sprintf('%01.2f',$distance) . ' Km';

        return $string;
    }

    // Converte para uma string com o tipo de dados
    public static function velocityConverter($velocity){

        $string = sprintf('%01.2f',$velocity) . ' Km/h';

        return $string;
    }
}