<?php

namespace backend\controllers;


use common\models\Client;
use common\models\Order;
use Yii;

use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\controllers\AppAdmin;

/**
 * Site controller
 */
class SiteController extends AppAdmin
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('permissionAdmin') && !Yii::$app->user->isGuest) {
            $order        = new Order();
            $client       = new Client();

            $typePackages = $order->getInfoTypePackge();

            $totalPack = $order->getTotalCountPackages();

            $totalCost = $order->getTotalValue('sum', 'cost');

            $totalSize = $order->getTotalValue('sum', 'size');

            $totalWeight = $order->getTotalValue('sum', 'weight');

            $avgCost = $order->getTotalValue('average', 'cost');

            $clients = $client->getCountClient();


            return $this->render(
                'index',
                [
                    'typePackages' => $typePackages,
                    'totalPack'    => $totalPack,
                    'totalCost'    => $totalCost,
                    'clients'      => $clients,
                    'totalSize'    => $totalSize,
                    'totalWeight'  => $totalWeight,
                    'avgCost'      => $avgCost,
                ]
            );
        }
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('noAccess', 'У вас нет доступа к этому разделу');

        return   $this->redirect('/admin/site/login') ;
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        $model = new LoginForm();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render(
                'login',
                [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect('/admin/site/login');
//        return $this->goHome();
    }

}
