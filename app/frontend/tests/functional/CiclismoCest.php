<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
class CiclismoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(2); // utilizador com username test
        $I->amOnRoute('ciclismo/index'); // Página de histórico
    }

    public function VerTreinos(FunctionalTester $I)
    {
        $I->see('Historico', 'h1');
        $I->seeLink('Percurso de teste');
        $I->see('2021-12-22 18:30:41', 'h5');
        $I->seeLink('Percurso para testes');
        $I->see('Distancia: 4.02 Km', 'div');
    }

    public function VerTreino(FunctionalTester $I)
    {
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
    }
}
