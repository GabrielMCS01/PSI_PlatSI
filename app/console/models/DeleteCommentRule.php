<?php

namespace common\models;

use yii\rbac\Rule;

class DeleteCommentRule extends Rule
{
    public $name = 'isDeleteComment';

    public function execute($user, $item, $params)
    {
        // Verifica se o comentário pertence ao utilizador
        return isset($params['comentario']) ? $params['comentario']->user_id == $user : false;
    }
}
