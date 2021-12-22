<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use Yii;
use common\models\LoginForm;

/**
 * Login form test
 */
class LoginFormTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */
    // Login sem receber quaisquer dados
    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => '',
            'password' => '',
        ]);

        expect_not($model->login());
        expect_that(Yii::$app->user->isGuest);
    }

    // Login com dados existentes na DB
    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'admin',
            'password' => 'adminadmin',
        ]);

        expect_that($model->login());
        expect_not(Yii::$app->user->isGuest);
    }

    // Login com palavra-passe errada
    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => 'admin',
            'password' => '123456789',
        ]);

        expect_not($model->login());

        expect($model->getFirstError('password'))
            ->equals('Palavra-passe Incorreta');

        expect_that(Yii::$app->user->isGuest);
    }
}
