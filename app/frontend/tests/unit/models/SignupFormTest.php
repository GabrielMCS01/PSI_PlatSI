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

        $this->assertEquals('test0', $user->getUsername());

        $this->tester->seeRecord('common\models\User', ['email' => 'test0@mail.com']);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => '',
            'email' => 'test0.com',
            'password' => '123456',
            'primeiro_nome' => '',
            'ultimo_nome' => ''
        ]);

        expect_not($model->signup());

        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));
        expect_that($model->getErrors('password'));
        expect_that($model->getErrors('primeiro_nome'));
        expect_that($model->getErrors('ultimo_nome'));
    }

    public function testDuplicatedSignup()
    {
        $model = new SignupForm([
            'username' => 'test0',
            'email' => 'test0@mail.com',
            'password' => '1234567890',
            'primeiro_nome' => 'user',
            'ultimo_nome' => 'teste'
        ]);

        $user = $model->signup();

        $this->assertEquals('test0', $user->getUsername());

        $this->tester->seeRecord('common\models\User', ['email' => 'test0@mail.com']);

        // Criado pela segunda vez para dar o erro
        $model = new SignupForm([
            'username' => 'test0',
            'email' => 'test0@mail.com',
            'password' => '1234567890',
            'primeiro_nome' => 'user',
            'ultimo_nome' => 'teste'
        ]);

        expect_not($model->signup());

        expect_that($model->getErrors('username'));
        expect_that($model->getErrors('email'));
        expect_not($model->getErrors('password'));
        expect_not($model->getErrors('primeiro_nome'));
        expect_not($model->getErrors('ultimo_nome'));

        expect($model->getFirstError('username'))
            ->equals('Este nome de utilizador já foi registado.');
        expect($model->getFirstError('email'))
            ->equals('Este email já foi registado.');
    }
}
