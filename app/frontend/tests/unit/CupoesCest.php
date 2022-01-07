<?php
namespace frontend\tests\unit;
use common\models\Cupoes;
use frontend\tests\UnitTester;
class CupoesCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function tryToTest(UnitTester $I)
    {
        $cupoe = new Cupoes([
            'codigo' => 'abc123',
            'codigo_verificacao' => 123,
            'user_id' => 1
        ]);

        expect_that($cupoe->save());

        $cupao_inserido = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupao_inserido != null);

        $cupao_inserido->codigo_verificacao = 124;

        expect_that($cupao_inserido->save());


    }
}
