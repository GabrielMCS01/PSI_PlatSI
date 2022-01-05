<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ciclismo;

/**
 * CiclismoSearch represents the model behind the search form of `common\models\Ciclismo`.
 */
class CiclismoSearch extends Ciclismo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'duracao', 'distancia', 'user_id'], 'integer'],
            [['nome_percurso', 'velocidade_grafico', 'rota', 'data_treino'], 'safe'],
            [['velocidade_media', 'velocidade_maxima'], 'number'],
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
        $query = Ciclismo::find();

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
            'duracao' => $this->duracao,
            'distancia' => $this->distancia,
            'velocidade_media' => $this->velocidade_media,
            'velocidade_maxima' => $this->velocidade_maxima,
            'data_treino' => $this->data_treino,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'nome_percurso', $this->nome_percurso])
            ->andFilterWhere(['like', 'velocidade_grafico', $this->velocidade_grafico])
            ->andFilterWhere(['like', 'rota', $this->rota]);

        return $dataProvider;
    }
}
