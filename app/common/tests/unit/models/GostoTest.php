<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Gosto;

/**
 * GostoTest test
 */
class GostoTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */

    // Testes para criar um gosto nas publicações
    public function testCreateGosto()
    {
        // Gosto criado corretamente
        $model = new Gosto([
            'publicacao_id' => 2,
            'user_id' => 4]);

        expect_that($model->save());

        // Pesquisa pelo ultimo nome do utilizador que colocou o gosto
        $this->assertEquals('Silva', $model->user->userinfo->ultimo_nome);

        // Pesquisa pelo gosto acabado de criar
        $gosto = Gosto::find()->where(['user_id' => '4', 'publicacao_id' => '2'])->one();

        expect_that($gosto->publicacao->ciclismo->duracao == 41091);

        // -------------------------------------------------------------------------------------
        // Tenta criar Gosto com dados incorretos
        $model = new Gosto([
            'publicacao_id' => 5, // Publicação não existe
            'user_id' => 4]);

        expect_not($model->save());

        expect_that($model->getErrors('publicacao_id'));

        // Tenta criar Gosto com dados incorretos
        $model = new Gosto([
            'publicacao_id' => 2,
            'user_id' => 8]); // Utilizador não existe

        expect_not($model->save());

        expect_that($model->getErrors('user_id'));
    }

    // Testes para visualizar todos os gostos de uma publicação
    public function testViewAllGostosPublicacao()
    {
        // Pesquisa pelos gostos na publicação com ID 1
        $gostos = Gosto::find()->where(['publicacao_id' => 1])->all();

        // Para o contador de gostos
        $numGostos = sizeof($gostos);

        foreach ($gostos as $gosto){
            expect_not($gosto->publicacao_id != 1);
        }
    }

    // Testes para visualizar um gosto
    public function testViewGosto()
    {
        // Pesquisa por um gosto feito pelo user com ID 4 (Só existe um nos dados de teste)
        $gosto = Gosto::find()->where(['user_id' => 4])->one();

        expect_that($gosto->publicacao->ciclismo->nome_percurso == 'Percurso de teste');
        expect_that($gosto->publicacao->ciclismo->user->username == 'test');
    }

    // NÃO PODE EDITAR

    // Testes para apagar um gosto de uma publicação
    public function testApagarGosto()
    {
        $gosto = Gosto::find()->where(['id' => 3])->one();

        expect_that($gosto->delete());
    }
}
