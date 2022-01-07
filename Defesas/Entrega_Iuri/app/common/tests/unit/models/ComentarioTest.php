<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Comentario;

/**
 * ComentarioTest test
 */
class ComentarioTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */

    // Testes para criar comentários nas publicações
    public function testCreateComentario()
    {
        // Comentário criado corretamente
        $model = new Comentario([
            'content' => 'Novo comentário',
            'createtime' => \Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH-mm-ss'),
            'publicacao_id' => 2,
            'user_id' => 2]);

        expect_that($model->save());

        // Pesquisa pelo username do utilizador que fez o percurso onde se colocou o comentário
        $this->assertEquals('gabriel', $model->publicacao->ciclismo->user->username);

        // Pesquisa pela publicação acabada de criar
        $comment = Comentario::find()->where(['user_id' => '2'])->one();

        expect_that($comment->content == 'Novo comentário');

        // -------------------------------------------------------------------------------------
        // Tenta criar Comentário com dados incorretos
        $model = new Comentario([
            'content' => 'Comentário não cria',
            'createtime' => \Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH-mm-ss'),
            'publicacao_id' => 4, // Publicação não existe
            'user_id' => 7]); // User não existe

        expect_not($model->save());

        expect_that($model->getErrors('publicacao_id'));
        expect_that($model->getErrors('user_id'));
    }

    // Testes para visualizar todos os comentários de uma publicação
    public function testViewAllComentariosPublicacao()
    {
        // Pesquisa pelo ID do treino e o ID do treino publicado onde o utilizador que fez o treino tem ID = 2
        $comments = Comentario::find()->where(['publicacao_id' => 1])->all();

        foreach ($comments as $comment){
            expect_not($comment->publicacao_id != 1);
        }
    }

    // Testes para visualizar todas os comentários (Moderador)
    public function testViewAllComentarios()
    {
        // Pesquisa por todos os comentários
        $comments = Comentario::find()->all();

        foreach ($comments as $comment){
            expect_that('publicacao_id' != null);
        }
    }

    // Testes para visualizar um comentário
    public function testViewComentario()
    {
        // Pesquisa pelo comentario feito pelo user com ID 5
        $comment = Comentario::find()->where(['user_id' => 5])->one();

        expect_that($comment->publicacao->ciclismo->nome_percurso == 'Percurso de teste');
        expect_that($comment->publicacao->ciclismo->user->username == 'test');
    }

    // Testes para editar um comentário
    public function testEditComentario()
    {
        // Testa se recebe o comentário da DB e modifica-o localmente
        $comment = Comentario::find()->where(['content' => 'comentário de teste'])->one();

        $comment->content = 'comentário Modificado';

        expect_that($comment->content == 'comentário Modificado');
        expect_not($comment->content == 'comentário de teste');
        // --------------------------------------------------------------
        // Atualiza o comentário na DB e recebe de novo o comentário
        $comment->save();

        $commentAtualizado = Comentario::find()->where(['content' => 'comentário Modificado'])->one();

        expect_that($commentAtualizado->publicacao_id == 1);
        expect_that($commentAtualizado->user_id == 4);
    }

    // Testes para apagar um comentário de uma publicação
    public function testApagarComentario()
    {
        $comment = Comentario::find()->where(['id' => 3])->one();

        expect_that($comment->delete());
    }
}
