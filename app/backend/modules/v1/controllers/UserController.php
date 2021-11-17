<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `v1` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
}
