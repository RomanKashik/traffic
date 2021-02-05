<?php

namespace common\models;

use common\behaviors\Total;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "registr_client".
 *
 * @property int $id
 * @property int|null $client_id
 * @property string|null $client_article
 * @property string|null $client_name
 * @property string|null $client_phone
 * @property string|null $client_city
 * @property string|null $client_area
 * @property int|null $client_carrier_id
 * @property string|null $client_carrier_article
 * @property string|null $client_carrier_name
 * @property string|null $client_carrier_phone
 * @property int|null $count
 * @property string|null $status
 * @property int|null $created_at
 * @property-read array $clientData
 * @property-read \yii\db\ActiveQuery $client
 * @property-read \yii\db\ActiveQuery $carrier
 * @property-read array $carrierData
 * @property int|null $updated_at
 */
class RegistrClient extends \yii\db\ActiveRecord
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
        return 'registr_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'count'], 'integer'],
            [
                [
                    'client_article',
                    'client_name',
                    'client_phone',
                    'client_city',
                    'client_area',
                    'client_carrier_id',
                    'client_carrier_article',
                    'client_carrier_name',
                    'client_carrier_phone'
                ],
                'string',
                'max' => 255
            ],
            [['client_id', 'client_carrier_id', 'count'], 'required'],
            ['status','safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'client_id'         => 'Клиент',
            'client_article'    => 'Артикул',
            'client_name'       => 'Клиент',
            'client_carrier_id' => 'Перевозчик',
            'count'             => 'Кол-во мест',
            'status'            => 'Статус',
            'created_at'        => 'Дата',
            'updated_at'        => 'Дата',
        ];
    }


    /**
     * Связь с таблицей [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
//TODO (Проверить все)
    public function getOrder()
    {
        return $this->hasMany(Order::class, ['user_id' => 'client_id']);
    }


    /**
     * Получите список имен клиентов
     * Gets query for [[Client]].
     *
     * @return array
     */
    public function getClientData()
    {
        $client = Client::find()->all();

        return ArrayHelper::map($client, 'id', 'name', 'article');
    }


    /**
     * Связь с таблицей [[Carrier]]
     * @return \yii\db\ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'client_carrier_id']);
    }

    /**
     * Получает запрос для [[Carrier]].
     * Получите список имен перевозчиков
     *
     * @return array
     */
    public function getCarrierData()
    {
        $article = Carrier::find()->all();

        return ArrayHelper::map($article, 'id', 'article', 'name');
    }


    /**
     * Получаем данные о клиенте для оформления
     * @param $client_id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getClientInfo($client_id)
    {
        return Client::find()->select(['name','article','city','area','phone'])->where(['id'=>$client_id])->asArray()
            ->one();
    }


    /**
     * Получаем данные о перевозчике для оформления
     * @param $carrier_id
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getCarrierInfo($carrier_id)
    {
        return Carrier::find()->select(['name','article','phone'])->where(['id'=>$carrier_id])->asArray()
            ->one();
    }


}
