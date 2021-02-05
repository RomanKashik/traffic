<?php


namespace common\behaviors;
use yii\base\Behavior;

class Total extends Behavior
{
    public static function getTotal($provider, $fieldName )
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return number_format($total, 3, '.', '');
    }

    public static function getTotalCount($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return number_format($total, 0, '.', '');
    }
}