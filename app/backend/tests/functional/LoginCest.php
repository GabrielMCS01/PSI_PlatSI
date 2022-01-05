<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * @param FunctionalTester $I
     */
    // Login Correto de um administrador
    public function LoginAdmin(FunctionalTester $I)
    {
        $I->amOnPage(['/site/index']);
        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'adminadmin');
        $I->click('login-button');

        $I->Seelink('Home');
        $I->Seelink('Utilizadores');
    }
}
