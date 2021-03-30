<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use kartik\select2\Select2;

/**
 * OrderSearch represents the model behind the search form of `common\models\Order`.
 */
class OrderSearch extends Order
{
    public $article;
    public $city;
    public $carrier_id;
    public $area;
    public $date_from;
    public $date_to;
//    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'string'],
            [['id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d-m-Y'],
            [
                [
                    'carrier_id',
                    'type_of_package_id',
                    'width',
                    'height',
                    'weight',
                    'length',
                    'size',
                    'cost',
                    'article',
                    'city',
                    'area',
                    'total',
                    'status'
                ],
                'safe'
            ],
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
        $query = Order::find();
        $query->joinWith(['client']);
        $query->joinWith(['clientReg']);
//        $query->joinWith(['packs']);


        // add conditions that should always apply here

        $dataProvider                              = new ActiveDataProvider(
            [
                'query' => $query,
//                'pagination' => [
//                    'pageSize' => 0,
//                ],
            ]
        );
        $dataProvider->pagination                  = false;
        $dataProvider->sort->attributes['article'] = [
            'asc'  => [Client::tableName().'.article' => SORT_ASC],
            'desc' => [Client::tableName().'.article' => SORT_DESC],

        ];
        $dataProvider->sort->attributes['city']    = [
            'asc'  => [Client::tableName().'.city' => SORT_ASC],
            'desc' => [Client::tableName().'.city' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['area']    = [
            'asc'  => [Client::tableName().'.area' => SORT_ASC],
            'desc' => [Client::tableName().'.area' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'id'      => $this->id,
//                'user_id' => $this->user_id,
               // 'created_at'        => $this->created_at,
               //               'updated_at' => $this->updated_at,
            ]
        );

        $query->andFilterWhere(['like', 'type_of_package_id', $this->type_of_package_id])
            ->andFilterWhere(['like', 'carrier_id', $this->carrier_id])
            ->andFilterWhere(['like', 'width', $this->width])
            ->andFilterWhere(['like', 'height', $this->height])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'length', $this->length])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'cost', $this->cost])
            ->andFilterWhere(['like', 'order.status', $this->status])
//            ->andFilterWhere(['like', 'article', $this->article])
            ->andFilterWhere(['like', RegistrClient::tableName().'.client_article', $this->article])
//            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', RegistrClient::tableName().'.client_city', $this->city])
//            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', RegistrClient::tableName().'.client_area', $this->area])
            ->andFilterWhere(['like', RegistrClient::tableName().'.client_name', $this->user_id]);
//            ->andFilterWhere(['like', Client::tableName().'.area', $this->area]);
        $query
            ->andFilterWhere(['>=','order.created_at', $this->date_from ? strtotime($this->date_from.' 00:00:00') :
                null])
            ->andFilterWhere(['<=','order.created_at', $this->date_to ? strtotime($this->date_to.' 23:59:59') : null]);
        return $dataProvider;
    }
}
