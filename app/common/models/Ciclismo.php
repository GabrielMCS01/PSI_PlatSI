<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ciclismo".
 *
 * @property int $id
 * @property string|null $nome_percurso
 * @property string $duracao
 * @property float $distancia
 * @property float $velocidade_media
 * @property float $velocidade_maxima
 * @property string|null $velocidade_grafico
 * @property string|null $rota
 * @property string $data_treino
 * @property int $user_id
 *
 * @property User $user
 */
class Ciclismo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ciclismo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['duracao', 'distancia', 'velocidade_media', 'velocidade_maxima', 'user_id'], 'required'],
            [['duracao', 'data_treino'], 'safe'],
            [['distancia', 'velocidade_media', 'velocidade_maxima'], 'number'],
            [['velocidade_grafico', 'rota'], 'string'],
            [['user_id'], 'integer'],
            [['nome_percurso'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome_percurso' => 'Nome Percurso',
            'duracao' => 'Duracao',
            'distancia' => 'Distancia',
            'velocidade_media' => 'Velocidade Media',
            'velocidade_maxima' => 'Velocidade Maxima',
            'velocidade_grafico' => 'Velocidade Grafico',
            'rota' => 'Rota',
            'data_treino' => 'Data Treino',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
