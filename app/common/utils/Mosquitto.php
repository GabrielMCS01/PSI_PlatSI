<?php

namespace common\utils;

class Mosquitto
{
    public static function FazPublish($canal, $mensagem){

        $server = "localhost";
        $port = 1883;
        $username = "ciclodias";
        $password = "serverciclodias2021";
        $client_id = "ciclodias-API"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $mensagem, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }
}