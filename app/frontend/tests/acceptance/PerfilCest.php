<?php
namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;

class PerfilCest
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

    // tests
    public function EditarPerfilTest(AcceptanceTester $I)
    {
        $I->wait(2);
        $I->see('Bem-Vindo ao Ciclodias');

        $I->wait(2);

        $I->seeLink('Perfil');
        $I->click('Perfil');

        $I->wait(2);

        $I->see('Perfil', 'h1');

        // Preenche o formulário e clica no botão para guardar as alterações
        $I->fillField('Primeiro Nome', 'Iuri');
        $I->wait(2);
        $I->fillField('Apelido', 'Teste');
        $I->wait(2);
        $I->fillField('Data de Nascimento', '2001-09-12');
        $I->clickWithLeftButton(null, 50, 20);
        $I->wait(2);

        $I->click('Guardar Alterações');

        $I->wait(2);
        $I->see('Bem-Vindo ao Ciclodias');
        $I->seeLink('Perfil');
        $I->click('Perfil');
        $I->wait(3);

        $I->see('Perfil', 'h1');
    }
}
