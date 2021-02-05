<?php

namespace frontend\controllers;

use Yii;
use common\models\TypeOfPackage;
use common\models\Unit;
use yii\filters\AccessControl;
use yii\web\Controller;

class ParameterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['stockman','admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $type = new TypeOfPackage();
        if ($type->load(Yii::$app->request->post()) && $type->save()) {
            Yii::$app->session->setFlash('success','Параметр сохранен');
            return $this->refresh();
        }

        $unit = new Unit();
        if ($unit->load(Yii::$app->request->post()) && $unit->save()) {
            Yii::$app->session->setFlash('success','Параметр сохранен');
            return $this->refresh();
        }

        return $this->render('index',compact('type','unit'));
    }

}
