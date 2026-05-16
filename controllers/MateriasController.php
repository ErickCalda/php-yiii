<?php

namespace app\controllers;

use Yii;
use app\models\Materias;
use app\models\MateriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MateriasController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new MateriasSearch();
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
    $model = new Materias();

    if ($model->load(Yii::$app->request->post())) {

        try {

            // sanitizar
            $model->nombre = trim($model->nombre);

            // validar vacío manualmente
            if (empty($model->nombre)) {
                return '0||materia|El nombre es obligatorio.|error';
            }

            // validar duplicado ignorando mayúsculas/minúsculas
            $existe = Materias::find()
                ->where('LOWER(TRIM(nombre)) = LOWER(:nombre)', [
                    ':nombre' => $model->nombre
                ])
                ->exists();

            if ($existe) {
                return '0||materia|Ya existe una materia con ese nombre.|error';
            }

            $model->codigo = 'MAT-' . str_pad(
                    (Materias::find()->count() + 1),
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            // guardar
            if ($model->save(false)) {

                return $model->id
                    . '|'
                    . $model->nombre
                    . '|materia'
                    . '|Materia creada correctamente'
                    . '|success';
            }

            return '0||materia|No se pudo guardar la materia.|error';

        } catch (\Throwable $e) {

            return '0||materia|' . $e->getMessage() . '|error';
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

            if ($model->save()) {

                return $model->id
                    . '|'
                    . $model->nombre
                    . '|materia'
                    . '|Materia actualizada correctamente'
                    . '|success';
            }

            // errores de validación
            $errores = $model->getFirstErrors();

            return '0||materia|'
                . reset($errores)
                . '|error';

        } catch (\Throwable $e) {

            return '0||materia|Ocurrió un error al actualizar.|error';
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
            . '|materia'
            . '|Materia eliminada correctamente'
            . '|success';
    }

    return 'error|No se pudo eliminar la materia|error';
}


protected function findModel($id)
{
    if (($model = Materias::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('Materia no encontrada.');
}
}