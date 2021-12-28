<?php
namespace frontend\tests\functional;
use common\models\Comentario;
use frontend\tests\FunctionalTester;
class ComentarioCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(2); // utilizador com username test
    }

    // Modelo para ser mais façil preencher o formulário
    protected function formParams($content)
    {
        return [
            'ComentarioForm[content]' => $content,
        ];
    }

    public function CriarComentarioTest(FunctionalTester $I)
    {
        // Página de publicações
        $I->amOnRoute('publicacao/index'); // Página de Feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('Ver Comentarios');
        $I->click('Ver Comentarios');

        // Página de comentários da publicação
        $I->see('Comentarios', 'h1');
        $I->seeLink('Criar Comentario');
        $I->click('Criar Comentario');

        // Página para adicionar novo comentário
        $I->see('Adicionar novo comentario', 'h1');

        // Preenche o formulário e clica no botão para criar
        $I->fillField('Content', 'Comentario de teste Funcional');
        $I->click('criarcomentario-button');

        // Verifica se o comentário foi criado
        $I->SeeRecord('common\models\Comentario', [
            'content' => 'Comentario de teste Funcional',
            'user_id' => 2,
            'publicacao_id' => 2
        ]);

        // Retorna á pagina de comentários
        $I->see('Comentarios', 'h1');
    }

}
