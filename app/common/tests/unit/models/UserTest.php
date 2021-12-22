<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\models\Ciclismo;
use common\models\Comentario;
use common\models\Gosto;
use common\models\Publicacao;
use common\models\User;

/**
 * UserTest test
 */
class UserTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */
    public function testViewUser()
    {
        $user = User::find()->where(['username' => 'test'])->one();

        expect_that($user->username == 'test');
        expect_not($user->username == 'moderador');

        $moderador = User::find()->where(['id' => '3'])->one();

        expect_not($moderador->email == 'test@gmail.com');
        expect_that($moderador->username == 'moderador');
    }

    public function testEditUser()
    {
        // Testa se recebe o utilizador da DB e modifica-o localmente
        $user = User::find()->where(['username' => 'test'])->one();

        $user->username = 'testModificado';

        expect_that($user->username == 'testModificado');
        expect_not($user->username == 'test');

        $user->email = 'modificado@mod.com';

        expect_not($user->username == 'test');
        expect_that($user->email == 'modificado@mod.com');
        // --------------------------------------------------------------
        // Atualiza o user na DB e recebe de novo o user da DB
        $user->save();

        $userAtualizado = User::find()->where(['username' => 'testModificado'])->one();

        expect_that($userAtualizado->email == 'modificado@mod.com');
        expect_that($userAtualizado->username == 'testModificado');
    }

    public function testApagarUser()
    {
        // Recebe um utilizador e as suas publicações
        expect_that($user = User::find()->where(['username' => 'test'])->one());
        expect_that($ciclismosUser = Ciclismo::find()->where(['user_id' => $user->id])->all());

        if($user != null){
            foreach ($ciclismosUser as $treino){
                Comentario::deleteAll(['publicacao_id' => $treino->publicacaos->id]);
                Gosto::deleteAll(['publicacao_id' => $treino->publicacaos->id]);
                Publicacao::deleteAll(['ciclismo_id' => $treino->id]);
                $treino->delete();
            }
            Comentario::deleteAll(['user_id' => $user->id]);
            Gosto::deleteAll(['user_id' => $user->id]);
            $user->userinfo->delete();
            $user->delete();
            expect_not($user = User::find()->where(['username' => 'test'])->one());
        }

        // Recebe o moderador e as suas publicações
        expect_that($moderador = User::find()->where(['id' => '3'])->one());
        expect_not($ciclismosMod = Ciclismo::find()->where(['user_id' => $moderador->id])->all());

        if($moderador != null){
            $moderador->userinfo->delete();
            $moderador->delete();
            expect_not($moderador = User::find()->where(['username' => 'moderador'])->one());
        }
    }
}
