<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegistrClient;

/**
 * RegistrClientSearch represents the model behind the search form of `frontend\models\RegistrClient`.
 */
class RegistrClientSearch extends RegistrClient
{

    public $date_from;
    public $date_to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['client_article', 'client_name', 'client_carrier_id','client_carrier_article','client_city', 'status'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
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
     * @param  array  $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RegistrClient::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination'=>false
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'id'         => $this->id,
                'client_id'  => $this->client_id,
                'count'      => $this->count,
//                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        );

        $query->andFilterWhere(['like', 'client_article', $this->client_article])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'client_carrier_id', $this->client_carrier_id])
            ->andFilterWhere(['like', 'client_carrier_article', $this->client_carrier_article])
            ->andFilterWhere(['like', 'client_city', $this->client_city])
            ->andFilterWhere(['like', 'status', $this->status]);
        $query
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);
        return $dataProvider;
    }
}

