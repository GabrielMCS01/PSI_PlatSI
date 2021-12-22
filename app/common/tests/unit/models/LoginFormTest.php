<?php

namespace common\tests\unit\models;

use frontend\models\SignupForm;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {

    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => '',
            'password' => '',
        ]);

        expect_not($model->login());
        expect_that(Yii::$app->user->isGuest);
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'admin',
            'password' => 'adminadmin',
        ]);

        expect_that($model->login());
        expect_not(Yii::$app->user->isGuest);
    }

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
