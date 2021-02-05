<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string|null $name
 */
class Unit extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{unit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['name'],  'filter', 'filter'=> function($value){ return mb_strtolower($value);}],
            [['name'], 'unique', 'message' => 'Такая единица уже есть'],
            [['name'], 'required', 'message' => 'Укажите единицу измерения'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Единицы измерения',
        ];
    }
    public function getPack()
    {
        return $this->hasOne(Pack::class, ['unit_id' => 'id']);
    }

}
