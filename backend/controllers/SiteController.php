<?php

namespace backend\controllers;


use common\models\Client;
use common\models\Order;
use common\models\User;
use Yii;

use common\models\LoginForm;

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
        $order = new Order();
        $client = new Client();

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
                'totalPack' => $totalPack,
                'totalCost' => $totalCost,
                'clients' => $clients,
                'totalSize' => $totalSize,
                'totalWeight' => $totalWeight,
                'avgCost' => $avgCost,
            ]
        );
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
        $model->password = ''; // перенести в метод rules формы, как default

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = User::findOne(['username' => $model->username]);

            if (Yii::$app->getAuthManager()->checkAccess($user->getId(), 'permissionAdmin')) {
                return $this->goHome();
            }

            Yii::$app->session->setFlash('noAccess', 'У вас нет доступа к этому разделу');
            return $this->refresh();
        }
        return $this->render(
            'login',
            [
                'model' => $model
            ]
        );
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
