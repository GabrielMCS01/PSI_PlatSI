<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cupoes;

/**
 * CupoesSearch represents the model behind the search form of `common\models\Cupoes`.
 */
class CupoesSearch extends Cupoes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'codigo_verificacao', 'user_id'], 'integer'],
            [['codigo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Cupoes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'codigo_verificacao' => $this->codigo_verificacao,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo]);

        return $dataProvider;
    }
}
