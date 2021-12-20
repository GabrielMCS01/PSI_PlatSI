<?php

namespace frontend\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use frontend\models\SignupForm;

class SignupFormTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'test0',
            'email' => 'test0@mail.com',
            'password' => '1234567890',
            'primeiro_nome' => 'user',
            'ultimo_nome' => 'teste'
        ]);

        $user = $model->signup();
        expect($user)->true();

        $this->tester->seeInDatabase('user', ['username' => 'test0']);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'test0',
            'email' => 'test0.com',
            'password' => '1234567',
            'primeiro_nome' => 'notuser',
            'ultimo_nome' => '123'
        ]);

        expect_not($model->signup());

        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));
        expect_that($model->getErrors('password'));

        expect($model->getFirstError('username'))
            ->equals('Este nome de utilizador já foi criado anteriormente, utilize outro.');
        expect($model->getFirstError('email'))
            ->equals('Este endereço de email já está a ser utilizado por outro utilizador.');
        expect($model->getFirstError('password'))
            ->equals('A palavra-passe tem que ter pelo menos 8 caracteres.');
    }
}
