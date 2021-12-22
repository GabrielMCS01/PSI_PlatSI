<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
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
        // Recebe um utilizador
        expect_that($user = User::find()->where(['username' => 'test'])->one());

        if($user != null){
            $user->userinfo->delete();
            $user->delete();
            expect_not($user = User::find()->where(['username' => 'test'])->one());
        }

        // Recebe um utilizador
        expect_that($moderador = User::find()->where(['id' => '3'])->one());

        if($moderador != null){
            $moderador->userinfo->delete();
            $moderador->delete();
            expect_not($moderador = User::find()->where(['username' => 'moderador'])->one());
        }

    }
}
