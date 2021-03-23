<?php

namespace common\models;


use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string|null $article
 * @property string|null $lastarticle
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $city
 * @property-read int $countClient
 * @property-read null|mixed $clientLastArticle
 * @property string|null $area
 */
class Client extends ActiveRecord
{

    public $lastarticle;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Заполните имя'],

            [['article'], 'required', 'message' => 'Заполните артикул'],
            [
                ['article'],
                'match',
                'pattern' => '/^[А-Я]+-[0-9]/',
                'message' => 'Пример правильного артикула Я-1, П-3... '
            ],
            [['article'], 'unique', 'message' => 'Такой артикул уже существует'],
            ['lastarticle', 'string'],
            [['phone'], 'trim'],
            [['phone'], 'default'],
            [
                ['name'],
                'match',
                'pattern' => '/^[А-Я]/',
                'message' => 'Пример правильного оформления Иванов, Бодров...'
            ],
            [
                ['city'],
                'match',
                'pattern' => '/^[А-Я]/',
                'message' => 'Пример правильного оформления Донецк, Ростов...'
            ],
            [
                ['area'],
                'match',
                'pattern' => '/^[А-Я]/',
                'message' => 'Пример правильного оформления Текстильщик, Ж/Д...'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name'        => 'Ф.И.О',
            'article'     => 'Артикул',
            'lastarticle' => 'Последний артикул',
            'phone'       => 'Телефон клиента',
            'city'        => 'Город',
            'area'        => 'Район/Рынок',
        ];
    }

    /**
     * Получение артикла последнего добавленного клиента
     *
     * @return mixed|null
     */
    public function getClientLastArticle()
    {
        return Client::find()->select(['article'])->orderBy(['article' => SORT_DESC])->one();
    }

    /**
     * Получение данных о клиенте
     *
     * @param $column_name  - название столбца в таблице Client
     *
     * @return array  Массив с данными о клиенте
     */
    public function getClientQueryData($column_name): array
    {
        $data = Client::find()->select([$column_name])->all();
        return ArrayHelper::map($data, $column_name, $column_name);
    }

    /**
     * Общее кол-во клиентов в таблице [[Client]]
     *
     * @return int
     */
    public function getCountClient(): int
    {
        return Client::find()->count('id');
    }


    /**
     * @param $id
     * Обновление данных клиента, в оформлении и заказе
     */
    public function updateRegClient($id)
    {
        $regClient = RegistrClient::find()->where(['client_id' => $id])->asArray()->one();
        if ($regClient) {
            if ($this->article !== $regClient->client_article && $this->name !== $regClient->client_name) {
                RegistrClient::updateAll(['client_article' => $this->article, 'client_name' => $this->name]);
            }
        }
    }

}


