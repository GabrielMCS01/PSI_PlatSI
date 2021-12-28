<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class RegistoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/signup');
    }

    // Modelo para ser mais façil preencher o formulário
    protected function formParams($username, $email, $password, $primeiro_nome, $ultimo_nome)
    {
        return [
            'SignupForm[username]'  => $username,
            'SignupForm[email]'     => $email,
            'SignupForm[password]'  => $password,
            'SignupForm[primeiro_nome]' => $primeiro_nome,
            'SignupForm[ultimo_nome]' => $ultimo_nome,
        ];
    }

    public function RegistoComCamposVazios(FunctionalTester $I)
    {
        $I->see('Registo', 'h1');
        $I->see('Preencha os campos seguintes com os seus dados para criar uma nova conta');
        $I->submitForm('#form-signup' ,$this->formParams('','','','',''));
        $I->seeValidationError('Username cannot be blank.');
        $I->seeValidationError('Email cannot be blank.');
        $I->seeValidationError('Password cannot be blank.');
        $I->seeValidationError('Primeiro Nome cannot be blank.');
        $I->seeValidationError('Ultimo Nome cannot be blank.');
    }

    public function RegistoComEmailInvalido(FunctionalTester $I)
    {
        $I->submitForm('#form-signup' ,$this->formParams(
            'testeInvalido',
            'abcde',
            'passwordTeste',
            'PrimeiroNomeTeste',
            'UltimoNomeTeste'
        ));
        $I->dontSee('Username cannot be blank.', '.invalid-feedback');
        $I->dontSee('Password cannot be blank.', '.invalid-feedback');
        $I->dontSee('Primeiro Nome cannot be blank.', '.invalid-feedback');
        $I->dontSee('Ultimo Nome cannot be blank.', '.invalid-feedback');
        $I->see('Email is not a valid email address.', '.invalid-feedback');
    }

    public function RegistoComSucesso(FunctionalTester $I)
    {
        $I->submitForm('#form-signup' ,$this->formParams(
            'testeFuncional',
            'teste@teste.com',
            'testepassword',
            'PrimeiroNomeTeste',
            'UltimoNomeTeste'
        ));

        $I->seeRecord('common\models\User', [
            'username' => 'testeFuncional',
            'email' => 'teste@teste.com',
        ]);
    }
}
