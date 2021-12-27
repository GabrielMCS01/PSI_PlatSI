<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * @param FunctionalTester $I
     */
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
