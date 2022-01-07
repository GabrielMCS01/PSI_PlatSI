<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id
 * @property string $username
 *
 * @property Cupoes[] $cupoes
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
        ];
    }

    /**
     * Gets query for [[Cupoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCupoes()
    {
        return $this->hasMany(Cupoes::className(), ['user_id' => 'id']);
    }
}
