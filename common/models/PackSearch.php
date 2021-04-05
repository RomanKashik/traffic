<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pack;

/**
 * PackSearch represents the model behind the search form of `frontend\models\Pack`.
 */
class PackSearch extends Pack
{

    public $date_from;
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id'], 'integer'],
            [['name', 'count', 'unit_id'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = Pack::find()->select(['name,unit_id, SUM(count) as count'])->groupBy(['name']);
        $query->joinWith(['order']);
        $query->where(['and',['order.status'=>'оформлен']]);

//        $query->joinWith(['client']);
        // add conditions that should always apply here

        $dataProvider             = new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );
        $dataProvider->pagination = false;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'id' => $this->id,
                //'order_id' => $this->order_id,
            ]
        );

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'count', $this->count])
            ->andFilterWhere(['like', 'unit_id', $this->unit_id]);
        $query
            ->andFilterWhere(['>=','pack.created_at', $this->date_from ? strtotime($this->date_from.' 00:00:00') :
                null])
            ->andFilterWhere(['<=','pack.created_at', $this->date_to ? strtotime($this->date_to.' 23:59:59') : null]);

        return $dataProvider;
    }
}
