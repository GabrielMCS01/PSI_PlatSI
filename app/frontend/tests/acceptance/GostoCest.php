<?php
namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;
class GostoCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function CriarEliminarGostoTest(AcceptanceTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);

        $I->wait(2);
        // Página de publicações
        $I->amOnRoute('publicacao/index'); // Página de Feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('');
        $I->click('', '#2');

        $I->wait(2);
        // Verifica se o comentário foi criado
        $I->SeeRecord('common\models\Gosto', [
            'user_id' => 5,
            'publicacao_id' => 1
        ]);
    }
}
