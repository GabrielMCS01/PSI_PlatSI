<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    // Não tem login feito
    public function VerificaLinksTexto(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Bem-Vindo ao Ciclodias', 'h1');
        $I->see('Aplicação de monitorização de exercício físico', 'p');
        $I->seeLink('Home');
        $I->seeLink('Registo');
        $I->seeLink('Iniciar sessão');
        $I->see('TOP 10 - Distância', 'h3');
        $I->see('TOP 10 - Duração', 'h3');
        $I->see('TOP 10 - Velocidade Média', 'h3');
    }

    public function ClicaLink(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->seeLink('Iniciar sessão');
        $I->click('Iniciar sessão');
        $I->see('Iniciar sessão', 'h1');
        $I->see('Preencha os seguintes campos com os seus dados de Utilizador:', 'p');
    }
}