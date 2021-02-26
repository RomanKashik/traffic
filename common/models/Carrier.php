<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "carrier".
 *
 * @property int $id
 * @property string|null $article
 * @property string|null $name
 * @property string|null $phone
 */
class Carrier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['article', 'required'],
            [['article'], 'unique', 'message' => 'Такой артикул уже существует'],
            [['article', 'name', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'article' => 'Артикул',
            'name'    => 'Ф.И.О',
            'phone'   => 'Телефон',
        ];
    }

    public function getCarrierData($column_name)
    {
        $data = Carrier::find()->select($column_name)->all();
        return ArrayHelper::map($data, $column_name, $column_name);
    }


}
