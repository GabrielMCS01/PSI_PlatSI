<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;

/**
 * UserTest test
 */
class PublicacaoTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */

    public function testCreatePublicacao()
    {
        // Publicação criado corretamente
        $model = new Publicacao([
            'createtime' => \Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH-mm-ss'),
            'ciclismo_id' => 2]);

        expect_that($model->save());

        $this->assertEquals(2, $model->ciclismo_id);

        // Pesquisa pela publicação acabada de criar
        $pub = Publicacao::find()->where(['ciclismo_id' => '3'])->one();

        expect_that($pub->ciclismo->user->id == 4);

        // -------------------------------------------------------------------------------------

        // Treino criado com dados incorretos
        /*$model = new Ciclismo([
            'nome_percurso' => '',
            'duracao' => 12.1, // Valor Inteiro
            'distancia' => 323.1, // Valor Inteiro
            'velocidade_media' => 43,
            'velocidade_maxima' => 3232,
            'user_id' => 20]); // Não existe

        expect_not($model->save());

        expect_that($model->getErrors('duracao'));
        expect_that($model->getErrors('distancia'));
        expect_that($model->getErrors('user_id'));*/
    }

     /*public function testViewAllTreino()
     {
         $treinos = Ciclismo::find()->where(['user_id' => 2])->all();

         foreach ($treinos as $treino){
             expect_not($treino->user_id != 2);
         }

         expect_not(Ciclismo::find()->where(['user_id' => 3])->all());
     }

     public function testEditTreino()
     {
         // Testa se recebe o utilizador da DB e modifica-o localmente
         $treino = Ciclismo::find()->where(['id' => 1])->one();

         $treino->nome_percurso = 'nome trocado';

         expect_that($treino->nome_percurso == 'nome trocado');
         expect_that($treino->nome_percurso != 'Percurso de teste');
         // --------------------------------------------------------------
         // Atualiza o user na DB e recebe de novo o user da DB
         expect_that($treino->save());

         $treinoAtualizado = Ciclismo::find()->where(['nome_percurso' => 'nome trocado'])->one();

         expect_that($treinoAtualizado->nome_percurso == 'nome trocado');
         expect_that($treinoAtualizado->velocidade_media == 10.1);
     }

     public function testApagarTreino()
     {
         expect_that($ciclismo = Ciclismo::find()->where(['id' => 1])->one());

         Comentario::deleteAll(['publicacao_id' => $ciclismo->publicacaos->id]);
         Gosto::deleteAll(['publicacao_id' => $ciclismo->publicacaos->id]);
         Publicacao::deleteAll(['ciclismo_id' => $ciclismo->id]);

         expect_that($ciclismo->delete());
     }*/
}
