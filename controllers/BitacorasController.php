<?php

namespace app\controllers;

use app\models\Bitacoras;
use app\models\BitacorasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Usuarios;
use Yii;

/**
 * BitacorasController implements the CRUD actions for Bitacoras model.
 */
class BitacorasController extends Controller
{
    /**
     * @inheritDoc
     */
   
public function behaviors()
{
    return [

        'access' => [
            'class' => AccessControl::class,
            'only' => ['create', 'update', 'delete'],
            'denyCallback' => function () {

                if (Yii::$app->request->isAjax) {
                    throw new \yii\web\ForbiddenHttpException('Sin permiso');
                }

                return $this->redirect(['site/index']);
            },
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function () {

                        return (int) Yii::$app->user->identity->rol_id === (int) Usuarios::ROL_ADMIN;
                    }
                ],
            ],
        ],

    ];
}
    /**
     * Lists all Bitacoras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BitacorasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }

    /**
     * Displays a single Bitacoras model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bitacoras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
public function actionCreate()
{
    $model = new Bitacoras();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return 'success';
    }

    $this->layout = false;

    return $this->renderAjax('_form', [
        'model' => $model,
    ]);
}

    /**
     * Updates an existing Bitacoras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return 'success';
    }

    $this->layout = false;

    return $this->renderAjax('_form', [
        'model' => $model,
    ]);
}
    /**
     * Deletes an existing Bitacoras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bitacoras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bitacoras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bitacoras::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }




    public function actionTable()
{
    $searchModel = new BitacorasSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('table', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
}
