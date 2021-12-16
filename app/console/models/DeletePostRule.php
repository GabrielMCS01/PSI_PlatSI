<?php

namespace console\models;

use yii\rbac\Rule;

class DeletePostRule extends Rule
{
    public $name = 'isDeletePost';

    public function execute($user, $item, $params)
    {
        // verifica se a publicação pertence aquele utilizador
        if(isset($params['publicacao'])) {
            if ($params['publicacao']->ciclismo->user_id == $user) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }
}
