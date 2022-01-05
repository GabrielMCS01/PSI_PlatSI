<?php
namespace frontend\tests\functional;
use common\models\Publicacao;
use frontend\tests\FunctionalTester;
class PublicacaoCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(2); // utilizador com username test
    }

    public function EliminarPublicacaoTest(FunctionalTester $I)
    {
        $I->amOnRoute('ciclismo/index'); // Página de histórico
        $I->see('Histórico', 'h1');
        $I->seeLink('Percurso de teste');
        $I->click('Percurso de teste');

        // Página do treino
        $I->see('Percurso de Teste', 'h1');
        $I->see('Distância: 0.90 Km');
        $I->see('Velocidade Média: 10.10 Km/h');
        $I->see('SEM ROTA', 'p');

        // Este percurso já tem publicação criada
        $I->seeLink('Publicado');
        $I->click('Publicado');

        // Verifica se a publicação foi eliminada
        $I->dontSeeRecord('common\models\Publicacao', [
            'ciclismo_id' => '1',
        ]);
    }

    public function CriarPublicacaoTest(FunctionalTester $I)
    {
        $I->amOnRoute('ciclismo/index'); // Página de histórico
        $I->see('Histórico', 'h1');
        $I->seeLink('Percurso de Foz a torres');
        $I->click('Percurso de Foz a torres');

        // Página do treino
        $I->see('Percurso de Foz a torres', 'h1');
        $I->see('Distância: 17.42 Km');
        $I->see('Velocidade Máxima: 30.54 Km/h');
        $I->see('SEM ROTA', 'p');

        // Cria publicação
        $I->seeLink('Publicar');
        $I->click('Publicar');

        // Verifica se o registo foi criado
        $I->seeRecord('common\models\Publicacao', [
            'ciclismo_id' => '2',
        ]);

        // Publicação acabada de criar
        $Publicacao = Publicacao::find()->where('ciclismo_id' == 2)->one();

        // Redireciona automaticamente para a página de feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Publicado por: test', 'h5');
        $I->see($Publicacao->ciclismo->nome_percurso, 'h3');
        $I->seeLink('Apagar Publicação');
        $I->seeLink('Ver Comentários');
    }

    public function VerPublicacoesTest(FunctionalTester $I)
    {
        $I->amOnRoute('site/index');
        $I->seeLink('Feed de notícias');
        $I->click('Feed de notícias');

        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->see('Percurso volta', 'h3');
    }
}
