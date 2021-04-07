<?php

namespace frontend\controllers;

use Yii;
use common\models\Client;
use common\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
                        'roles' => ['market', 'admin'],
                    ],
//                     [
//                         'allow' => true,
//                         'actions' => ['index'],
//                         'roles' => ['stockman'],
//                     ],
                ],

            ],
        ];
    }

    /**
     * Lists all Client models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render(
            'index',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Client model.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render(
            'view',
            [
                'model' => $this->findModel($id),
            ]
        );
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        $article = $model->getClientLastArticle()->article;
        if (!$article) {
            $article = 'Это первый артикул';
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Клиент добавлен');
            return $this->redirect(['index']);
//            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            'create',
            [
                'model'   => $model,
                'article' => $article,
            ]
        );
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param  int  $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->updateRegClient($id);
            Yii::$app->session->setFlash('success', 'Клиент обновлен');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            'update',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  integer  $id
     *
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
