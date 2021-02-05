<?php

namespace common\models;

use common\behaviors\Total;
use DateTime;
use phpDocumentor\Reflection\Types\Self_;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Sort;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\grid\Column;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;


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
 * @property-read \yii\db\ActiveQuery $type
 * @property-read array $clientData
 * @property-read int $totalCountPackages
 * @property-read \yii\db\ActiveQuery $client
 * @property-read \yii\db\ActiveQuery $clientReg
 * @property-read array $infoTypePackge
 * @property-read array $carrierArticles
 * @property-read string $rate
 * @property-read \yii\db\ActiveQuery $carrier
 * @property-read mixed $typePackage
 * @property-read string[] $status
 * @property Pack[] $packs
 */
class Order extends ActiveRecord
{
    public const STATUS_ISSUED = 'оформлен';
    public const STATUS_CHECKED = 'проверен';

    protected const RATE = '20000';


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
            [['weight', 'notes', 'created_at', 'updated_at', 'total', 'carrier_id', 'client_id', 'status'], 'safe'],
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



    /* public function afterSave()
     {
         if (is_array($this->status)) {
             foreach ($this->status as $statusName) {
                 $this->status = $statusName;
                 self::save();
             }
         }
     }*/

    /**
     * Gets query for [[Packs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPacks()
    {
        return $this->hasMany(Pack::class, ['order_id' => 'id']);
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

    /**
     * Gets query for [[registr_client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientReg()
    {
        return $this->hasOne(RegistrClient::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Carrier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrier()
    {
        return $this->hasOne(Carrier::class, ['id' => 'carrier_id']);
    }

    /**
     * Gets query for [[TypeOfPackage]].
     *
     * @return \yii\db\ActiveQuery
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
     * Данные о типах упаовки и их количестве
     *
     * @return array
     */
    public function getInfoTypePackge(): array
    {
        return Order::find()
            ->select(['COUNT(order.type_of_package_id)  as count,  type_of_package.name'])
            ->join('LEFT JOIN', 'type_of_package', 'type_of_package.id = order.type_of_package_id')
            ->groupBy('type_of_package.id')->asArray()->all();
    }

    /**
     * Общее кол-во упаковок
     *
     * @return int
     */
    public function getTotalCountPackages(): int
    {
        return Order::find()->count('type_of_package_id');
    }

    /**
     * Получение итоговые значения из таблицы [[Order]]
     *
     * @param $column_name  - имя столбца в таблице
     *
     * @param $operation  - название функции mysql
     *
     * @return float
     */

    public function getTotalValue($operation, $column_name): float
    {
        return number_format(Order::find()->$operation($column_name), 2, '.', '');
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
        )->where(['registr_client.status' => 'active'])->join(
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

    /* public function checkCount()
     {
         $registrClient = RegistrClient::find()->select(
             [
                 'COUNT(order.user_id) as count_user_id,registr_client.id'
             ]
         )->join(
             'LEFT JOIN',
             'order',
             'order.user_id = registr_client.id'
         )->groupBy('registr_client.created_at')->asArray()->all();


         if ($registrClient['count'] == $registrClient['count_user_id']) {
             return true;
         }

         //return false;
     }*/


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Пиздец нахуй блядь');
        } else {
            $registrClient = RegistrClient::find()->select(
                [
                    'COUNT(order.user_id) as count_user_id,registr_client.id,registr_client.count'
                ]
            )->join(
                'LEFT JOIN',
                'order',
                'order.user_id = registr_client.id'
            )->groupBy('registr_client.id')->asArray()->all();
            echo '<pre>';
            var_dump($registrClient);
            die();
            foreach ($registrClient as $item){
                if ($item['count'] == $item['count_user_id']) {
                    $reg         = RegistrClient::find()->where(['id' => $this->user_id])->one();
                    $reg->status = 'formalized';
                    $reg->update();
                    Yii::$app->session->setFlash('success', 'А хуя тебе на воротник');
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
     * @param $column_name_like  - название столбца в таблице с каким сравнивать  [[registr_client]]
     *
     * @param  string  $column_name  - название столбца в таблице по какому искать  [[registr_client]]
     *
     * @return array
     */
    public function getClientOrderData($column_name_like, $column_name = 'id')
    {
        $data = Order::find()->with('clientReg')->asArray()->all();
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
     * Получить статус заказа
     *
     * @return string[]
     */
    public function getStatus()
    {
        return [
            self::STATUS_ISSUED  => 'Оформлен',
            self::STATUS_CHECKED => 'Проверен',
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
