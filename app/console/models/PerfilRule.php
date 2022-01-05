<?php

namespace console\models;

use yii\rbac\Rule;

class PerfilRule extends Rule
{
    public $name = 'isPerfil';

    public function execute($user, $item, $params)
    {
        // Verifica se o user está a pedir informações do seu perfil
        return isset($params['user']) ? $params['user']->id == $user : false;
    }
}