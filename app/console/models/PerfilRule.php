<?php

namespace console\models;

use yii\rbac\Rule;

class PerfilRule extends Rule
{
    public $name = 'isPerfil';

    public function execute($user, $item, $params)
    {
        return isset($params['activity']) ? $params['activity']->id == $user : false;
    }
}