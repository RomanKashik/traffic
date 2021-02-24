<?php

namespace common\modules\tracking\controllers;

use common\models\Client;
use common\models\RegistrClient;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `tracking` module
 */
class DefaultController extends Controller
{
    /**
     * Форма поиска заказов клиентов по артикулу и номеру телефона
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post()) {
            $user = Client::find()
                ->where('article=:article', [':article' => Yii::$app->request->post('article')])
                ->andWhere(
                    'phone=:phone',
                    [':phone' => Yii::$app->request->post('phone')]

                )->asArray()->all();

            if (!$user) {
                Yii::$app->session->setFlash('danger', 'Неправильный артикул или номер телефона');
                return $this->render('index');
            }

            $model = RegistrClient::find()
                ->where(
                    'client_article=:client_article',
                    [':client_article' => Yii::$app->request->post('article')]
                )
                ->andWhere(
                    'client_phone=:client_phone',
                    [':client_phone' => Yii::$app->request->post('phone')]
                )->asArray()->all();

            $dataProvider = new ArrayDataProvider(['allModels' => $model]);

            return $this->render('view', ['model' => $model, 'dataProvider' => $dataProvider]);
        }

        return $this->render('index');
    }


    /*public function actionCreate()
    {
        if (Yii::$app->request->post()) {

            $user = Client::find()
                ->where('article=:article',[':article' => Yii::$app->request->post('client_article')])
                ->andWhere( 'phone=:phone',[':phone' => Yii::$app->request->post('client_phone')]

            )->asArray()->one();

            if (!$user) {
              $error = 'Неправильный артикул или номер телефона';
                Yii::$app->session->setFlash('danger', 'Неправильный артикул или номер телефона');
                return $this->render('create',['error'=>$error]);
            }

            $model = RegistrClient::find()
                ->where(
                    'client_article=:client_article',
                    [':client_article' => Yii::$app->request->post('client_article')]
                )
                ->andWhere(
                    'client_phone=:client_phone',
                    [':client_phone' => Yii::$app->request->post('client_phone')]
                )->asArray()->all();

            $dataProvider = new ArrayDataProvider(['allModels' => $model]);

            return $this->render('index', ['model' => $model, 'dataProvider' => $dataProvider]);
        }

        return $this->render('create');
    }*/
}
