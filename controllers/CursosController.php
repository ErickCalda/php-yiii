<?php

namespace app\controllers;

use Yii;
use app\models\Cursos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CursosController extends Controller
{
    /*
    =====================================
    CREAR CURSO DESDE DRAWER
    =====================================
    */
public function actionCreate()
{
    $model = new Cursos();

    if (
        $model->load(Yii::$app->request->post())
        && $model->save()
    ) {

        return $model->id
            . '|'
            . $model->nombre
            . '|curso'
            . '|Curso creado correctamente'
            . '|success';
    }

    return $this->renderAjax('create', [
        'model' => $model,
    ]);
}
    /*
    =====================================
    EDITAR
    =====================================
    */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (
            $model->load(Yii::$app->request->post())
            && $model->save()
        ) {

            return $model->id
                . '|'
                . $model->nombre
                . '|curso';
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /*
    =====================================
    ELIMINAR
    =====================================
    */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return 'deleted';
    }

    /*
    =====================================
    BUSCAR
    =====================================
    */
    protected function findModel($id)
    {
        if (($model = Cursos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'Curso no encontrado.'
        );
    }
}