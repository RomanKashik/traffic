<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "type_of_package".
 *
 * @property int $id
 * @property-read mixed $typePackage
 * @property string|null $name
 */
class TypeOfPackage extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{type_of_package}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'],  'filter', 'filter'=> function($value){ return mb_strtolower($value);}],
            [['name'], 'unique', 'message' => 'Такой тип упаковки уже есть'],
            [['name'], 'required', 'message' => 'Укажите тип упаковки'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип упаковки',
        ];
    }




}
