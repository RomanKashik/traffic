<?php

namespace backend\controllers;

use common\models\RegistrClient;
use Yii;
use common\models\Order;
use common\models\OrderSearch;
use common\models\Pack;
use frontend\models\Model;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;


/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
                    'delete'          => ['POST'],
                    'multiple-delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
//                        'actions' => ['index', 'view', 'create', 'update', 'product', 'delete','multiple-delete'],
                        'roles' => ['admin'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Lists all Order models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 10;

        return $this->render(
            '@frontend/views/order/index',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,

            ]
        );
    }

    /**
     * Displays a single Order model.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelsPack = Pack::find()->where(['order_id' => $id])->all();
        if (!$modelsPack) {
            throw new NotFoundHttpException('Empty pack');
        }

        $dataProvider = new ActiveDataProvider(
            [
                'query' => Order::find()->with('clientReg', 'packs')->where(['id' => $id])
            ]
        );

        return $this->render(
            '@frontend/views/order/view',
            [
                'dataProvider' => $dataProvider,
                'model'        => $this->findModel($id),
                'modelsPack'   => $modelsPack,
            ]
        );
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model      = new Order();
        $modelsPack = [new Pack()];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelsPack = Model::createMultiple(Pack::class);
            Model::loadMultiple($modelsPack, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPack),
                    ActiveForm::validate($model)
                );
            }
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPack) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPack as $modelPack) {
                            $modelPack->order_id = $model->id;
                            $modelPack->user_id  = $model->user_id;
                            Yii::$app->session->setFlash('success', 'Заказ сохранен');
                            if (!($flag = $modelPack->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        $client_id         = $model->user_id;
                        $carrier_id        = $model->getCarrierId($client_id);
                        $model->carrier_id = $carrier_id['client_carrier_id'];
//                        $model->status = implode(', ',$model->status);
                        foreach ($model->status as $model->status) {
                            $model->save();
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['create']);
//                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render(
                '@frontend/views/order/create',
                [
                    'model'      => $model,
                    'modelsPack' => (empty($modelsPack)) ? [new Pack()] : $modelsPack
                ]
            );
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model      = $this->findModel($id);
        $modelsPack = $model->packs;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $oldIDs     = ArrayHelper::map($modelsPack, 'id', 'id');
            $modelsPack = Model::createMultiple(Pack::class, $modelsPack);
            Model::loadMultiple($modelsPack, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPack, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPack) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            Pack::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPack as $modelPack) {
                            $modelPack->order_id = $model->id;
                            $modelPack->user_id  = $model->user_id;
                            if (!($flag = $modelPack->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        $client_id         = $model->user_id;
                        $carrier_id        = $model->getCarrierId($client_id);
                        $model->carrier_id = $carrier_id['client_carrier_id'];
//                        $model->status = implode(', ',$model->status);
                        foreach ($model->status as $model->status) {
                            $model->save();
                        }
                        if (Yii::$app->user->can('permissionStockDPR')) {
                            self::checkStatus();
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render(
                '@frontend/views/order/update',
                [
                    'model'      => $model,
                    'modelsPack' => (empty($modelsPack)) ? [new Pack] : $modelsPack
                ]
            );
        }
    }

    /**
     * Making report.
     *
     * @return mixed
     */
    public function actionClient()
    {
        $searchModel  = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render(
            '@frontend/views/order/client',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Обновление статусов у выбранных клиентов
     *
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionMultipleCheck()
    {
        $id = Yii::$app->request->post('row_id_to_update');
        Order::updateAll(['status' => 'готов к выдаче'], ['id' =>$id]);


        self::checkStatus();

        Yii::$app->session->setFlash('info', 'Статус обновлен');



        return $this->redirect(['index']);
    }

    public static function checkStatus (){
        $status = Order::find()->select(['order.status, user_id, COUNT(*) AS order_count, registr_client.count,registr_client.id'])
            ->join(
                'LEFT JOIN',
                'registr_client',
                'registr_client.id = order.user_id'
            )->groupBy(
                'order.status, user_id'
            )->having(
                'order_count >= 1'
            )->asArray()->all();

        foreach ($status as $item) {
            if ($item['count'] == $item['order_count']) {
                $reg         = RegistrClient::find()->where(['id' => $item['id']])->one();
                $reg->status = 'Готов к выдаче';
                $reg->update();
            }

        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  int  $id
     *
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
