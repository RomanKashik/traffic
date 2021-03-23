<?php

namespace backend\controllers;

use common\models\RegistrClientSearch;
use Yii;
use common\models\RegistrClient;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegistrClientController implements the CRUD actions for RegistrClient model.
 */
class RegistrClientController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
//                        'actions' => ['login', 'signup'],
                        'roles' => ['admin'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Lists all RegistrClient models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new RegistrClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            '@frontend/views/registr-client/index',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single RegistrClient model.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render(
            '@frontend/views/registr-client/view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    /**
     * Creates a new RegistrClient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RegistrClient();


        if ($model->load(Yii::$app->request->post())) {
//            Получаем  id выбранного клиента
            $client_id = $model->client_id;
//            Получаем о нем данные и сохраняем
            $client = $model->getClientInfo($client_id);

            $model->client_name    = $client['name'];
            $model->client_article = $client['article'];
            $model->client_phone   = $client['phone'];
            $model->client_city    = $client['city'];
            $model->client_area    = $client['area'];

//            Получаем  id выбранного перевозчика
            $carrier_id = $model->client_carrier_id;
//            Получаем о нем данные и сохраняем
            $carrier = $model->getCarrierInfo($carrier_id);

            $model->client_carrier_article = $carrier['article'];
            $model->client_carrier_name    = $carrier['name'];
            $model->client_carrier_phone   = $carrier['phone'];
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            '@frontend/views/registr-client/create',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Updates an existing RegistrClient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model  = $this->findModel($id);
        $client = $model->getClientInfo($id);

      /*  echo '<pre>';
        var_dump($client);
        exit();*/

        if ($model->load(Yii::$app->request->post())) {
            $model->client_phone = $client['phone'];
            $model->client_city  = $client['city'];
            $model->client_area  = $client['area'];

            // Получаем  id выбранного перевозчика
            $carrier_id = $model->client_carrier_id;
            //  Получаем о нем данные и сохраняем
            $carrier = $model->getCarrierInfo($carrier_id);

            $model->client_carrier_article = $carrier['article'];
            $model->client_carrier_name    = $carrier['name'];
            $model->client_carrier_phone   = $carrier['phone'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            '@frontend/views/registr-client/update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Удаление списка оформленных клиентов
     *
     * @return \yii\web\Response
     *
     */
    public function actionMultipleDelete()
    {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->post('row_id_to_delete')) {
                $id = Yii::$app->request->post('row_id_to_delete');

                /*foreach ($pk as $key => $value)
                {
                    $sql = "DELETE FROM order WHERE id = $value";
                    $query = Yii::$app->db->createCommand($sql)->execute();
                }*/
                RegistrClient::deleteAll(['id' => $id]);
                $msg = Yii::$app->session->setFlash('success', 'Выбранные клиенты удалены');

                return $this->redirect(['index', 'msg' => $msg]);
            } else {
                $msg = Yii::$app->session->setFlash('info', 'Выберите клиентов для удаления');
                return $this->redirect(['index', 'msg' => $msg]);
            }
        }
    }

    /**
     * Deletes an existing RegistrClient model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RegistrClient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  int  $id
     *
     * @return RegistrClient the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RegistrClient::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
