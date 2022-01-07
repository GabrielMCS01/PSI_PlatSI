<?php

namespace common\tests\unit\models;


use Codeception\Test\Unit;
use common\models\Clientes;
use common\models\Cupoes;


/**
 * CupoesTest test
 */
class CupoesTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    /**
     * @return array
     */

    public function testCreateAndReadCupao(){

        $clientes = new Clientes();

        $clientes->nome = 'test';
        $clientes->save();

        $cupao = new Cupoes();

        $cupao->codigo = 'QAZXSWEDC45RIUJNBGYT';
        $cupao->codigo_verificacao = '963';
        $cupao->user_id = 1;

        expect_that($cupao->save());

        $cupaoPesquisa = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupaoPesquisa->codigo_verificacao == '963');
    }


    public function testUpdateCupao(){

        $clientes = new Clientes();

        $clientes->nome = 'test';
        $clientes->save();

        $cupao = new Cupoes();

        $cupao->codigo = 'QAZXSWEDC45RIUJNBGYT';
        $cupao->codigo_verificacao = '963';
        $cupao->user_id = 1;

        $cupao->save();

        expect_that($cupao->codigo_verificacao == '963');

        $cupaoUpdate = Cupoes::find()->where(['user_id' => 1])->one();

        $cupaoUpdate->codigo_verificacao = '126';

        $cupaoUpdate->save();

        $cupaoRead = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupaoRead->codigo_verificacao == '126');

        expect_not($cupaoRead->codigo_verificacao == '963');
    }

    public function testDeleteCupao(){

        $clientes = new Clientes();

        $clientes->nome = 'test';
        $clientes->save();


        $cupao = new Cupoes();

        $cupao->codigo = 'QAZXSWEDC45RIUJNBGYT';
        $cupao->codigo_verificacao = '963';
        $cupao->user_id = 1;

        $cupao->save();

        $cupaoPesquisa = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupaoPesquisa->codigo_verificacao == '963');

        $cupaoDelete = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupaoDelete->delete());

        $cupaoRead = Cupoes::find()->where(['user_id' => 1])->one();

        expect_that($cupaoRead == null);

    }

    public function testValidadeCupao(){

        $clientes = new Clientes();

        $clientes->nome = 'test';
        $clientes->save();

        $cupao = new Cupoes();

        $cupao->codigo = null;
        $cupao->codigo_verificacao = '963123';
        $cupao->user_id = 1;

        expect_not($cupao->save());
    }
}