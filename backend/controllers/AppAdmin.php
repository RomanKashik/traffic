<?php


namespace backend\controllers;


use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppAdmin extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles'=>['?']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


}