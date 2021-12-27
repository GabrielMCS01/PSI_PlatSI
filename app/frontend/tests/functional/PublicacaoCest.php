<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
class PublicacaoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(2); // utilizador com username test
    }

    // tests
    public function EliminarPublicacaoTest(FunctionalTester $I)
    {
        $I->amOnRoute('ciclismo/index'); // Página de histórico
        $I->see('Historico', 'h1');
        $I->seeLink('Percurso de teste');
        $I->click('Percurso de teste');

        // Página do treino
        $I->see('Percurso de Teste', 'h1');
        $I->see('Distancia: 0.90 Km');
        $I->see('Velocidade Média: 10.10 Km/h');
        $I->see('SEM ROTA', 'p');

        // Este percurso já tem publicação criada
        $I->seeLink('Publicado');
        $I->click('Publicado');
    }
}
