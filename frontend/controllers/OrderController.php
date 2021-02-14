<?php

namespace frontend\controllers;

use common\models\RegistrClient;
use Yii;
use common\models\Order;
use common\models\OrderSearch;
use common\models\Pack;
use frontend\models\Model;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'product', 'delete'],
                        'roles' => ['stockman', 'stockmanDPR', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['client'],
                        'roles' => ['manager', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['driver'],
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
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 10;

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,

            ]
        );
    }

    /**
     * Displays a single Order model.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelsPack = Pack::find()->where(['order_id' => $id])->all();
        if (!$modelsPack) {
            throw new NotFoundHttpException('Empty pack');
        };


//        $query = Order::find()->with(['clientReg'])->where(['id'=>$id])
//            ->asArray()
//            ->all();

//        array_push($query, $modelsPack);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Order::find()->with('clientReg','packs')->where(['id' => $id])
            ]
        );

//        echo '<pre>';
//        var_dump($dataProvider);
//        die();
        return $this->render(
            'view',
            [
                'dataProvider' => $dataProvider,
                'model' => $this->findModel($id),
                'modelsPack' => $modelsPack,
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
        $model = new Order();
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
                            $modelPack->user_id = $model->user_id;
                            Yii::$app->session->setFlash('success', 'Заказ сохранен');
                            if (!($flag = $modelPack->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        $client_id = $model->user_id;
                        $carrier_id = $model->getCarrierId($client_id);
                        $model->carrier_id = $carrier_id['client_carrier_id'];
//                        $model->status = implode(', ',$model->status);
                        $model->save();
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['order/create']);
//                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render(
                'create',
                [
                    'model' => $model,
                    'modelsPack' => (empty($modelsPack)) ? [new Pack()] : $modelsPack
                ]
            );
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPack = $model->packs;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $oldIDs = ArrayHelper::map($modelsPack, 'id', 'id');
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
                            $modelPack->user_id = $model->user_id;
                            if (!($flag = $modelPack->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        $client_id = $model->user_id;
                        $carrier_id = $model->getCarrierId($client_id);
                        $model->carrier_id = $carrier_id['client_carrier_id'];
//                        $model->status = implode(', ',$model->status);
                        $model->save();
                    }
//                    $model->status = implode(', ',$model->status);

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
                'update',
                [
                    'model' => $model,
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
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render(
            'client',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }


    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
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
