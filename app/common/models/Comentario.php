<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id
 * @property string $content
 * @property string|null $createtime
 * @property int $publicacao_id
 * @property int $user_id
 *
 * @property Publicacao $publicacao
 * @property User $user
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'publicacao_id', 'user_id'], 'required'],
            [['content'], 'string'],
            [['createtime'], 'safe'],
            [['publicacao_id', 'user_id'], 'integer'],
            [['publicacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publicacao::className(), 'targetAttribute' => ['publicacao_id' => 'id']],
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
            'content' => 'Content',
            'createtime' => 'Createtime',
            'publicacao_id' => 'Publicacao ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Publicacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublicacao()
    {
        return $this->hasOne(Publicacao::className(), ['id' => 'publicacao_id']);
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