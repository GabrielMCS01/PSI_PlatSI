<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cupoes".
 *
 * @property int $id
 * @property string $codigo
 * @property int $codigo_verificacao
 * @property int $user_id
 *
 * @property Clientes $user
 */
class Cupoes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cupoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'codigo_verificacao', 'user_id'], 'required'],
            [['codigo_verificacao', 'user_id'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'codigo_verificacao' => 'Codigo Verificacao',
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
        return $this->hasOne(Clientes::className(), ['id' => 'user_id']);
    }
}
