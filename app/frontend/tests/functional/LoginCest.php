<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    // Modelo para ser mais façil preencher o formulário
    protected function formParams($username, $password)
    {
        return [
            'LoginForm[username]' => $username,
            'LoginForm[password]' => $password,
        ];
    }

    public function LoginSemDados(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
    }

    public function LoginPasswordIncorreta(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin', 'wrong'));
        $I->seeValidationError('Palavra-passe Incorreta');
    }

    public function LoginCorreto(FunctionalTester $I)
    {
        $I->seeLink('Registo');
        $I->seeLink('Iniciar sessão');
        $I->submitForm('#login-form', $this->formParams('test', '123456789'));
        $I->see('Logout (test)', 'form button[type=submit]');
    }
}
