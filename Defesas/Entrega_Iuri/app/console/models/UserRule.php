<?php

namespace console\models;

use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'isUser';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        // Verifica se o treino tem o ID do USER que está a fazer o pedido
        return isset($params['activity']) ? $params['activity']->user_id == $user : false;
    }
}