<?php

namespace app\controllers;

use app\models\Bitacoras;
use app\models\BitacorasSearch;
use app\models\Usuarios;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class BitacorasController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return (int) Yii::$app->user->identity->rol_id === (int) Usuarios::ROL_ADMIN;
                        }
                    ],
                ],
                'denyCallback' => function () {
                    throw new \yii\web\ForbiddenHttpException('Sin permiso');
                },
            ],
        ];
    }

    /* =========================
     * LISTADO
     * ========================= */
    public function actionIndex()
    {
        $searchModel = new BitacorasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* =========================
     * VER
     * ========================= */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /* =========================
     * CREAR (AJAX MODAL)
     * ========================= */
    public function actionCreate()
    {
        $model = new Bitacoras();

        if ($model->load(Yii::$app->request->post())) {

            // ⚡ guardar directamente (usuario y estado se manejan en beforeSave)
            if ($model->save()) {
                return 'success';
            }

            // 🔥 devolver errores reales si falla
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $model->errors;
        }

        $this->layout = false;

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /* =========================
     * ACTUALIZAR
     * ========================= */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return 'success';
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $model->errors;
        }

        $this->layout = false;

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /* =========================
     * ELIMINAR
     * ========================= */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /* =========================
     * FIND MODEL
     * ========================= */
    protected function findModel($id)
    {
        if (($model = Bitacoras::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe.');
    }

    /* =========================
     * TABLA VIEW (OPCIONAL)
     * ========================= */
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