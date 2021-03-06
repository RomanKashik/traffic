<?php

namespace common\models;

use common\behaviors\Total;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property int|null $carrier_id
 * @property string|null $type_of_package_id
 * @property string|null $width
 * @property string|null $height
 * @property string|null $weight
 * @property string|null $length
 * @property string|null $size
 * @property string|null $cost
 * @property int|null $date
 * @property int|null $date_update
 *
 * @property-read ActiveQuery $type
 * @property-read array $clientData
 * @property-read int $totalCountPackages
 * @property-read ActiveQuery $client
 * @property-read ActiveQuery $clientReg
 * @property-read array $infoTypePackge
 * @property-read array $carrierArticles
 * @property-read string $rate
 * @property-read ActiveQuery $carrier
 * @property-read mixed $typePackage
 * @property-read string[] $status
 * @property Pack[] $packs
 */
class Order extends ActiveRecord
{
    public const STATUS_ISSUED = 'оформлен';
    public const STATUS_CHECKED = 'готов к выдаче';
    public const STATUS_ISSUED_IN_WAREHOUSE = 'оформлен на складе';
    protected const RATE = '21000';


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
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type_of_package_id', 'width', 'height', 'length'], 'double'],
            [['size', 'cost'], 'double'],
            [['weight', 'notes', 'created_at', 'updated_at', 'total', 'carrier_id', 'client_id'], 'safe'],
            [['status'], 'required', 'message' => 'Отметьте статус заказа'],
            [['notes'], 'string'],
            [['user_id', 'type_of_package_id', 'width', 'height', 'weight', 'length', 'size', 'cost'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'user_id'            => 'Клиент',
            'carrier_id'         => 'Перевозчик',
            'type_of_package_id' => 'Тип упаковки',
            'width'              => 'Ширина',
            'height'             => 'Высота',
            'length'             => 'Длина',
            'weight'             => 'Вес',
            'size'               => 'Объём',
            'cost'               => 'Стоимость',
            'notes'              => 'Примечания',
            'status'             => '',
            'created_at'         => 'Дата',
            'updated_at'         => 'Дата обновления',
        ];
    }


    /**
     * Gets query for [[Packs]].
     *
     * @return ActiveQuery
     */
    public function getPacks()
    {
        return $this->hasMany(Pack::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[registr_client]].
     *
     * @return ActiveQuery
     */
    public function getClientReg()
    {
        return $this->hasOne(RegistrClient::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Carrier]].
     *
     * @return ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'carrier_id']);
    }

    /**
     * Gets query for [[TypeOfPackage]].
     *
     * @return ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TypeOfPackage::class, ['id' => 'type_of_package_id']);
    }

    /**
     * Получение данных об упаковке для выпадающего списка
     *
     * @return mixed
     */
    public function getTypePackage()
    {
        $type = TypeOfPackage::find()->asArray()->all();

        return ArrayHelper::map($type, 'id', 'name');
    }

    /**
     * Данные о типах упаковки и их количестве
     *
     * @return array
     */
    public function getInfoTypePackge(): array
    {
        return Order::find()
            ->select(['COUNT(order.type_of_package_id)  as count,  type_of_package.name'])
            ->join('LEFT JOIN', 'type_of_package', 'type_of_package.id = order.type_of_package_id')
            ->where(['status'=>'оформлен'])
            ->groupBy('type_of_package.id')->asArray()->one();
    }

    /**
     * Получение итоговые значения из таблицы [[Order]]
     *
     * @return array|\yii\db\ActiveRecord|null
     */

    public function getTotalValues()
    {
        return Order::find()->select(
            'SUM(cost) as cost, AVG(cost) as average_cost, SUM(size) as size,SUM(weight) as weight, COUNT(type_of_package_id) as count_package,status'
        )
            ->where(['status'=>'оформлен'])
            ->asArray()
            ->all();
    }

    /**
     * Получение имени и кол-ва мест зарегистрированных клиентов для выпадающего списка
     * в форме оформления заказа
     *
     * @return array
     */
    public function getClientData()
    {
        $registrClient = RegistrClient::find()->select(
            [
                'COUNT(order.user_id) as count_user_id, user_id,registr_client.id, registr_client.client_name,
         registr_client.count, registr_client.created_at '
            ]
        )->where(['registr_client.status' => 'принят'])->join(
            'LEFT JOIN',
            'order',
            'order.user_id = registr_client.id'
        )->groupBy('registr_client.created_at')->asArray()->all();

        return ArrayHelper::map(
            $registrClient,
            'id',
            function ($data) {
                return $data['client_name'].' '.'(мест '.$data['count'].' / '.$data['count_user_id'].')';
            },
            function ($data) {
                return Yii::$app->formatter->asDate($data['created_at'], 'php:d-m-Y');
            }
        );
    }


    /**
     * Проверяем кол-ва мест с кол-вом заказов клиента
     * Меняем status в таблице [[registr_client]]
     *
     * @param  bool  $insert
     * @param  array  $changedAttributes
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Что-то пошло не так!');
        } else {
            $checkCount = RegistrClient::find()->select(
                [
                    'COUNT(order.user_id) as count_user_id,
                    order.status,
                    registr_client.id,
                    registr_client.count,
                    registr_client.client_name'
                ]
            )->join(
                'LEFT JOIN',
                'order',
                'order.user_id = registr_client.id'
            )->groupBy('order.user_id')->asArray()->all();


            foreach ($checkCount as $item) {
                if ($item['count'] === $item['count_user_id'] && $item['id'] == $this->user_id) {
                    $reg         = RegistrClient::find()->where(['id' => $this->user_id])->one();
                    $reg->status = self::STATUS_ISSUED_IN_WAREHOUSE;
                    $reg->update();
                    if (Yii::$app->user->can('permissionStock') ) {
                        Yii::$app->session->setFlash('success', $item['client_name'].' оформлен');
                    }
                } elseif (Yii::$app->user->can('permissionStock') ) {
                    Yii::$app->session->setFlash(
                        'success',
                        $item['client_name'].' осталось оформить мест '.($item['count'] - $item['count_user_id'])
                    );
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Получение данных перевозчика для выпадающего списка
     *
     * @return array
     */
    public function getCarrierArticles()
    {
        $article = Order::find()->with('clientReg')->asArray()->all();

        return ArrayHelper::map(
            $article,
            'clientReg.client_carrier_id',
            'clientReg.client_carrier_article',
            'clientReg.client_carrier_name'
        );
    }

    /**
     * Получаем данные о перевозчике для оформления клиента
     *
     * @param $client_id
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getCarrierId($client_id)
    {
        return RegistrClient::find()->select(['client_carrier_id'])->where(['id' => $client_id])->asArray()
            ->one();
    }

    /**
     * Получение данных клиента
     *
     * @param  string  $column_name_like  - название столбца в таблице с каким сравнивать  [[registr_client]]
     *
     * @param  string  $column_name  - название столбца в таблице по какому искать  [[registr_client]]
     *
     * @return array
     */
    public function getClientOrderData($column_name_like, $column_name = 'id')
    {
        $data = Order::find()->joinWith('clientReg')->asArray()->all();
        return ArrayHelper::map($data, 'clientReg.'.$column_name, 'clientReg.'.$column_name_like);
    }

    /**
     * Ставка на перевозку
     *
     * @return string
     */

    public function getRate()
    {
        return self::RATE;
    }

    /**
     * Получить статус заказа по роли
     *
     * @return string[]
     */
    public function getStatus()
    {
        if (Yii::$app->user->can('permissionAdmin')) {
            return $status = [
                self::STATUS_ISSUED  => 'Оформлен',
                self::STATUS_CHECKED => 'Готов к выдаче',
            ];
        }

        if (Yii::$app->user->can('permissionStockDPR')) {
            return $status = [
                self::STATUS_CHECKED => 'Готов к выдаче',
            ];
        } else {
            return $status = [
                self::STATUS_ISSUED => 'Оформлен'
            ];
        }
    }

    /**
     * Выбор статуса заказа
     *
     * @return string[]
     */

    public function getStatuses()
    {
        return $status = [
            self::STATUS_ISSUED  => 'Оформлен',
            self::STATUS_CHECKED => 'Готов к выдаче',
        ];
    }

    /**
     * Deleting a list of items
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        foreach ($this->packs as $pack) {
            $pack->delete();
        }
        return parent::beforeDelete();
    }

}
