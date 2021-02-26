<?php

namespace backend\controllers;

use Yii;
use common\models\Pack;
use common\models\PackSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PackController implements the CRUD actions for Pack model.
 */
class PackController extends Controller
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
                'class'        => AccessControl::class,
                'rules'        => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],

            ],
        ];
    }

    /**
     * Lists all Pack models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new PackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            '@frontend/views/pack/index',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Pack model.
     *
     * @param  integer  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render(
            '@frontend/views/pack/view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    /**
     * Creates a new Pack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pack();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['@frontend/views/pack/view', 'id' => $model->id]);
        }

        return $this->render(
            '@frontend/views/pack/create',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Updates an existing Pack model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  integer  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['@frontend/views/pack/view', 'id' => $model->id]);
        }

        return $this->render(
            '@frontend/views/pack/update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Deletes an existing Pack model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['@frontend/views/pack/index']);
    }

    /**
     * Finds the Pack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer  $id
     *
     * @return Pack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pack::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
