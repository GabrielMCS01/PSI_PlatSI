<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "publicacao".
 *
 * @property int $id
 * @property string|null $createtime
 * @property int $ciclismo_id
 *
 * @property Ciclismo $ciclismo
 * @property Comentario[] $comentarios
 * @property Gosto[] $gostos
 */
class Publicacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publicacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime'], 'safe'],
            [['ciclismo_id'], 'required'],
            [['ciclismo_id'], 'integer'],
            [['ciclismo_id'], 'unique'],
            [['ciclismo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciclismo::className(), 'targetAttribute' => ['ciclismo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Createtime',
            'ciclismo_id' => 'Ciclismo ID',
        ];
    }

    /**
     * Gets query for [[Ciclismo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCiclismo()
    {
        return $this->hasOne(Ciclismo::className(), ['id' => 'ciclismo_id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['publicacao_id' => 'id']);
    }

    /**
     * Gets query for [[Gostos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGostos()
    {
        return $this->hasMany(Gosto::className(), ['publicacao_id' => 'id']);
    }
}
