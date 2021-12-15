<?php

namespace common\models;

use yii\rbac\Rule;

class DeletePostRule extends Rule
{
    public $name = 'isPerfil';

    public function execute($user, $item, $params)
    {
        // Verifica se o user está a pedir informações do seu perfil
        return isset($params['user']) ? $params['user']->id == $user : false;
    }
}
