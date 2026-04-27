<?php

namespace app\controllers;

use Yii;
use app\models\PeriodosAcademicos;
use app\models\PeriodosAcademicosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PeriodosAcademicosController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PeriodosAcademicosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new PeriodosAcademicos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PeriodosAcademicos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Periodo académico no encontrado.');
    }
}