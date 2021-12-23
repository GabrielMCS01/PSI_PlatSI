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

    // Testes para criar publicações
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
        // Tenta criar Publicação com dados incorretos
        $model = new Publicacao([
            'createtime' => \Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH-mm-ss'),
            'ciclismo_id' => 20]); // Este treino não existe na DB de testes

        expect_not($model->save());

        expect_that($model->getErrors('ciclismo_id'));
    }

    // Testes para visualizar todas as publicações de um utilizador
    public function testViewAllPublicacoesUser()
    {
        // Pesquisa pelo ID do treino e o ID do treino publicado onde o utilizador que fez o treino tem ID = 2
        $pubs = Publicacao::find()->innerJoin(['ciclismo'], 'ciclismo.id = publicacao.ciclismo_id')->where(['ciclismo.user_id' => '2'])->all();

        foreach ($pubs as $pub){
            expect_that($pub->ciclismo->user_id == 2);
        }
    }

    // Testes para visualizar todas as publicações (Feed Noticias)
    public function testViewAllPublicacoes()
    {
        // Pesquisa por todas as publicações
        expect_that($pubs = Publicacao::find()->all() != null);
    }

    // Testes para visualizar uma publicação
    public function testViewPublicacao()
    {
        // Pesquisa pela publicação que pertença ao treino com ID 3
        $pub = Publicacao::find()->where(['ciclismo_id' => 3])->one();

        expect_that($pub->ciclismo->user->username == 'gabriel');
        expect_not($pub->ciclismo->user->username == 'test');
    }

    // NAO PODE EDITAR

    // Testes para apagar uma publicação do utilizador
    public function testApagarPublicacao()
    {
        expect_that($pub = Publicacao::find()->where(['id' => 1])->one());

        Comentario::deleteAll(['publicacao_id' => $pub->id]);
        Gosto::deleteAll(['publicacao_id' => $pub->id]);

        expect_that($pub->delete());
    }
}
