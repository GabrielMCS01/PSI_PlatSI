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
    // Testes para visualizar um utilizador
    public function testViewUser()
    {
        $user = User::find()->where(['username' => 'test'])->one();

        expect_that($user->username == 'test');
        expect_not($user->username == 'moderador');

        $moderador = User::find()->where(['id' => '3'])->one();

        expect_not($moderador->email == 'test@gmail.com');
        expect_that($moderador->username == 'moderador');
    }

    // Visualizar todos os tipos de utilizadores (backend)
    public function testViewAllUser()
    {
        // Ver todos os Utilizadores
        $users = User::find()->innerJoin(['auth_assignment'], 'user.id = auth_assignment.user_id')->where(['item_name' => 'user'])->all();

        foreach ($users as $user){
            expect_that($user->authassignment->item_name == 'user');
        }

        // Ver todos os Moderadores
        $moderadores = User::find()->innerJoin(['auth_assignment'], 'user.id = auth_assignment.user_id')->where(['item_name' => 'moderador'])->all();

        foreach ($moderadores as $mod){
            expect_that($mod->authassignment->item_name == 'moderador');
        }

        // Ver todos os Administradores
        $admins = User::find()->innerJoin(['auth_assignment'], 'user.id = auth_assignment.user_id')->where(['item_name' => 'admin'])->all();

        foreach ($admins as $admin){
            expect_that($admin->authassignment->item_name == 'admin');
        }
    }

    // Testes para editar um perfil de utilizador
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

    // Testes para apagar um perfil do utilizador
    public function testApagarUser()
    {
        // Recebe um utilizador e as suas publicações
        expect_that($user = User::find()->where(['username' => 'test'])->one());
        expect_that($ciclismosUser = Ciclismo::find()->where(['user_id' => $user->id])->all());

        if($user != null){
            // Apaga tudo relativo ás publicações, treinos daquele utilizador (Comentários de outros utilizadores)
            foreach ($ciclismosUser as $treino){
                if (Publicacao::find()->where(['ciclismo_id' => $treino->id])->one() == true) {
                    Comentario::deleteAll(['publicacao_id' => $treino->publicacao->id]);
                    Gosto::deleteAll(['publicacao_id' => $treino->publicacao->id]);
                    Publicacao::deleteAll(['ciclismo_id' => $treino->id]);
                }
                $treino->delete();
            }
            // Apaga tudo o que o utilizador tem relativo a ele
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
            // Apaga tudo relativo ás publicações, treinos daquele utilizador (Comentários de outros utilizadores)
            foreach ($ciclismosMod as $treinoMod){
                if (Publicacao::find()->where(['ciclismo_id' => $treinoMod->id])->one() == true) {
                    Comentario::deleteAll(['publicacao_id' => $treinoMod->publicacao->id]);
                    Gosto::deleteAll(['publicacao_id' => $treinoMod->publicacao->id]);
                    Publicacao::deleteAll(['ciclismo_id' => $treinoMod->id]);
                }
                $treinoMod->delete();
            }
            // Apaga tudo o que o utilizador tem relativo a ele
            Comentario::deleteAll(['user_id' => $moderador->id]);
            Gosto::deleteAll(['user_id' => $moderador->id]);
            $moderador->userinfo->delete();
            $moderador->delete();
            expect_not($moderador = User::find()->where(['username' => 'moderador'])->one());
        }
    }
}
