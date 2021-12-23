<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;

/**
 * UserTest test
 */
class CiclismoTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */

    // Testes para criar treinos
    public function testCreateTreino()
    {
        // Treino criado corretamente
        $model = new Ciclismo([
            'nome_percurso' => 'Percurso de testes',
            'duracao' => 1242,
            'distancia' => 4509,
            'velocidade_media' => 9.92,
            'velocidade_maxima' => 25.41,
            'user_id' => 2]);

        expect_that($model->save());

        $this->assertEquals(1242, $model->duracao);

        // Pesquisa pelo treino acabado de criar
        $treino = Ciclismo::find()->where(['nome_percurso' => 'Percurso de testes'])->one();

        expect_that($treino->velocidade_media == 9.92);
        // -------------------------------------------------------------------------------------
        // Tenta criar Treino com dados incorretos
        $model = new Ciclismo([
            'nome_percurso' => '',
            'duracao' => 12.1, // Valor Inteiro
            'distancia' => 323.1, // Valor Inteiro
            'velocidade_media' => 43,
            'velocidade_maxima' => 3232,
            'user_id' => 20]); // Não existe

        expect_not($model->save());

        expect_that($model->getErrors('duracao'));
        expect_that($model->getErrors('distancia'));
        expect_that($model->getErrors('user_id'));
    }

    // Testes para visualizar todos os treinos de um utilizador
    public function testViewAllTreino()
    {
        $treinos = Ciclismo::find()->where(['user_id' => 2])->all();

        foreach ($treinos as $treino) {
            expect_not($treino->user_id != 2);
        }

        expect_not(Ciclismo::find()->where(['user_id' => 3])->all());
    }

    // Testes para visualizar um treino do utilizador
    public function testViewTreino()
    {
        $treino = Ciclismo::find()->where(['user_id' => 2])->one();

        expect_not($treino->user_id != 2);

        expect_not(Ciclismo::find()->where(['user_id' => 3])->one());
    }

    // Testes para editar um treino do utilizador
    public function testEditTreino()
    {
        // Testa se recebe o treino da DB e modifica-o localmente
        $treino = Ciclismo::find()->where(['id' => 1])->one();

        $treino->nome_percurso = 'nome trocado';

        expect_that($treino->nome_percurso == 'nome trocado');
        expect_that($treino->nome_percurso != 'Percurso de teste');
        // --------------------------------------------------------------
        // Atualiza o treino na DB e recebe de novamente o treino da DB
        expect_that($treino->save());

        $treinoAtualizado = Ciclismo::find()->where(['nome_percurso' => 'nome trocado'])->one();

        expect_that($treinoAtualizado->nome_percurso == 'nome trocado');
        expect_that($treinoAtualizado->velocidade_media == 10.1);
    }

    // Testes para apagar um treino do utilizador
    public function testApagarTreino()
    {
        expect_that($ciclismo = Ciclismo::find()->where(['id' => 1])->one());

        if (Publicacao::find()->where(['ciclismo_id' => $ciclismo->id])->one() == true) {
            Comentario::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
            Gosto::deleteAll(['publicacao_id' => $ciclismo->publicacao->id]);
            Publicacao::deleteAll(['ciclismo_id' => $ciclismo->id]);
        }
        expect_that($ciclismo->delete());
    }
}
