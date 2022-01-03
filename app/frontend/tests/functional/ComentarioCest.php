<?php
namespace frontend\tests\functional;
use common\models\Comentario;
use frontend\tests\FunctionalTester;
class ComentarioCest
{
    public function _before(FunctionalTester $I)
    {
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
        $I->amLoggedInAs(2); // utilizador com username test

        // Página de publicações
        $I->amOnRoute('publicacao/index'); // Página de Feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('Ver Comentários');
        $I->click('Ver Comentários');

        // Página de comentários da publicação
        $I->see('Comentários', 'h1');
        $I->seeLink('Criar Comentário');
        $I->click('Criar Comentário');

        // Página para adicionar novo comentário
        $I->see('Adicionar novo comentário', 'h1');

        // Preenche o formulário e clica no botão para criar
        $I->fillField('Comentário', 'Comentário de teste Funcional');
        $I->click('pubcomentario-button');

        // Verifica se o comentário foi criado
        $I->SeeRecord('common\models\Comentario', [
            'content' => 'Comentário de teste Funcional',
            'user_id' => 2,
            'publicacao_id' => 2
        ]);

        // Retorna á pagina de comentários
        $I->see('Comentários', 'h1');
    }

    public function DeleteComentarioTest(FunctionalTester $I)
    {
        $I->amLoggedInAs(4); // utilizador com username gabriel

        // Página de publicações
        $I->amOnRoute('publicacao/index'); // Página de Feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('Ver Comentários');
        $I->click('Ver Comentários', '#1');

        // Página de comentários da publicação
        $I->see('Comentários', 'h1');
        $I->see('gabriel', 'h3');
        $I->seeLink('Editar Comentário');
        $I->click('Editar Comentário');

        // Página para ver o comentário
        $I->see('Comentário de gabriel', 'h1');
        $I->seeLink('Apagar');
        $I->click('Apagar');

        // Retorna á pagina de comentários
        $I->see('Comentários', 'h1');

        // Verifica se o comentário foi criado
        $I->DontSeeRecord('common\models\Comentario', [
            'content' => 'comentário de teste',
            'user_id' => 4,
            'publicacao_id' => 1
        ]);
    }

    public function EditComentarioTest(FunctionalTester $I)
    {
        $I->amLoggedInAs(5); // utilizador com username iuri

        // Página de publicações
        $I->amOnRoute('publicacao/index'); // Página de Feed de noticias
        $I->see('Publicações', 'h1');
        $I->see('Percurso de teste', 'h3');
        $I->seeLink('Ver Comentários');
        $I->click('Ver Comentários', '#1');

        // Página de comentários da publicação
        $I->see('Comentários', 'h1');
        $I->see('iuri', 'h3');
        $I->seeLink('Editar Comentário');
        $I->click('Editar Comentário');

        // Página para ver o comentário
        $I->see('Comentário de iuri', 'h1');
        $I->seeLink('Atualizar');
        $I->click('Atualizar');

        // Página para editar o comentário
        $I->see('Atualizar comentário', 'h1');
        // Preenche o formulário e clica no botão para guardar as alterações
        $I->fillField('Comentário', 'Comentário de teste Funcional');
        $I->click('pubcomentario-button');

        // Voltar para a página do comentário
        $I->see('Comentário de iuri', 'h1');

        // Verifica se o comentário foi editado
        $I->SeeRecord('common\models\Comentario', [
            'content' => 'Comentário de teste Funcional (Editado)',
            'user_id' => 5,
            'publicacao_id' => 1
        ]);
    }
}
