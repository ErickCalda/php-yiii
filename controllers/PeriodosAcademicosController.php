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

    if ($model->load(Yii::$app->request->post())) {

        try {

            $model->nombre = trim($model->nombre);

            if (empty($model->nombre)) {
                return '0||periodo|El nombre es obligatorio.|error';
            }

            $existe = PeriodosAcademicos::find()
                ->where('LOWER(TRIM(nombre)) = LOWER(:nombre)', [
                    ':nombre' => $model->nombre
                ])
                ->exists();

            if ($existe) {
                return '0||periodo|Ya existe un período con ese nombre.|error';
            }

            if ($model->save(false)) {

                return $model->id
                    . '|'
                    . $model->nombre
                    . '|periodo'
                    . '|Período creado correctamente'
                    . '|success';
            }

            return '0||periodo|No se pudo guardar el período.|error';

        } catch (\Throwable $e) {

            return '0||periodo|' . $e->getMessage() . '|error';
        }
    }

    return $this->renderAjax('create', [
        'model' => $model,
    ]);
}




public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post())) {

        try {

            $model->nombre = trim($model->nombre);

            if (empty($model->nombre)) {
                return '0||periodo|El nombre es obligatorio.|error';
            }

            if ($model->save(false)) {

                return $model->id
                    . '|'
                    . $model->nombre
                    . '|periodo'
                    . '|Período actualizado correctamente'
                    . '|success';
            }

            return '0||periodo|No se pudo actualizar el período.|error';

        } catch (\Throwable $e) {

            return '0||periodo|' . $e->getMessage() . '|error';
        }
    }

    return $this->renderAjax('update', [
        'model' => $model,
    ]);
}

public function actionDelete($id)
{
    $model = $this->findModel($id);

    $nombre = $model->nombre;

    if ($model->delete()) {

        return $model->id
            . '|'
            . $nombre
            . '|periodo'
            . '|Período eliminado correctamente'
            . '|success';
    }

    return '0||periodo|No se pudo eliminar el período.|error';
}

    protected function findModel($id)
    {
        if (($model = PeriodosAcademicos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Periodo académico no encontrado.');
    }
}