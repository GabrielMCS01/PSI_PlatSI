<?php
namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;
class GostoCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->seeLink('Iniciar sessão');
        $I->click('Iniciar sessão');

        $I->wait(2);
        $I->see('Iniciar sessão', 'h1');
        $I->fillField('Username', 'iuri');
        $I->wait(2);
        $I->fillField('Password', '123456789');
        $I->wait(2);
        $I->seeLink('Iniciar sessão');
        $I->click('login-button');
    }

    public function CriarEliminarGostoTest(AcceptanceTester $I)
    {
        $I->wait(5);
        $I->seeLink('Feed de notícias');
        $I->click('Feed de notícias');

        $I->wait(2);
        // Página de publicações
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('');
        $I->wait(1);
        $I->click('#gosto1');

        $I->wait(2);
    }
}
