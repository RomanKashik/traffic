<?php

namespace common\models;

use common\behaviors\Total;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pack".
 *
 * @property int $id
 * @property int|null $order_id
 * @property string|null $name
 * @property string|null $count
 * @property string|null $unit_id
 *
 * @property Order $order
 */
class Pack extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class'      => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'total' => [
                'class' => Total::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pack';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255,'min'=>1],
            [['user_id','created_at','updated_at'],'safe'],
            ['name',  'filter', 'filter'=> function($value){ return mb_strtolower($value);}],
            [['order_id', 'count', 'unit_id'], 'number'],
            [['name', 'count', 'unit_id'], 'required'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id'=>'Клиент',
            'name' => 'Наименование',
            'count' => 'Количество',
            'unit_id' => 'Ед.измерения',
            'created_at'=>'Дата'
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }


    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'user_id']);
    }


    public function getClientNameOrder()
    {
        $client = Order::find()->with('client')->all();

        return ArrayHelper::map($client, 'client.name', 'client.name');
    }

    public function getUnits(){

        $unit = Unit::find()->all();

        return ArrayHelper::map($unit, 'id', 'name');
    }

    public function getUnitPack(){

        $unit = Unit::find()->with('pack')->all();

        return ArrayHelper::map($unit, 'pack.unit_id', 'name');
    }

    public function getPackName()
    {
        $packName = Pack::find()->distinct()->all();
        return ArrayHelper::map($packName, 'name', 'name');
    }



}
