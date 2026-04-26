<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

use app\models\Laboratorios;
use app\models\LaboratoriosSearch;
use app\models\CatTiposLaboratorio;
use app\models\CatEstadosLaboratorio;
use app\models\Ubicaciones;
use app\models\Usuarios;

class LaboratoriosController extends Controller
{
    /**
     * Behaviors
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
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return !Yii::$app->user->isGuest
                                && Yii::$app->user->identity->rol_id == Usuarios::ROL_ADMIN;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lista
     */
    public function actionIndex()
    {
        $searchModel = new LaboratoriosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Ver detalle
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crear
    */


public function actionCreate()
{
    $model = new Laboratorios();

    $tipos = ArrayHelper::map(CatTiposLaboratorio::find()->all(), 'id', 'nombre');

    $estados = ArrayHelper::map(CatEstadosLaboratorio::find()->all(), 'id', 'nombre');

    $ubicaciones = ArrayHelper::map(
        Ubicaciones::find()->all(),
        'id',
        fn($u) => $u->edificio . ' - ' . $u->aula
    );

    $responsables = $this->getResponsables();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {

        Yii::$app->session->setFlash('toast', [
            'type' => 'success',
            'message' => 'Laboratorio creado correctamente.'
        ]);

        return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('create', compact(
        'model',
        'tipos',
        'estados',
        'ubicaciones',
        'responsables'
    ));
}

public function actionUpdate($id)
{
    $model = $this->findModel($id);

    $tipos = ArrayHelper::map(CatTiposLaboratorio::find()->all(), 'id', 'nombre');

    $estados = ArrayHelper::map(CatEstadosLaboratorio::find()->all(), 'id', 'nombre');

    $ubicaciones = ArrayHelper::map(
        Ubicaciones::find()->all(),
        'id',
        fn($u) => $u->edificio . ' - ' . $u->aula
    );

    $responsables = $this->getResponsables();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {

        Yii::$app->session->setFlash('toast', [
            'type' => 'success',
            'message' => 'Laboratorio actualizado correctamente.'
        ]);

        return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', compact(
        'model',
        'tipos',
        'estados',
        'ubicaciones',
        'responsables'
    ));
}
    /**
     * Eliminar
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->getEquipos()->exists()) {

            Yii::$app->session->setFlash('toast', [
                'type' => 'error',
                'message' => 'No se puede eliminar este laboratorio porque tiene equipos registrados.'
            ]);

            return $this->redirect(['index']);
        }

        $model->delete();

        Yii::$app->session->setFlash('toast', [
            'type' => 'success',
            'message' => 'Laboratorio eliminado correctamente.'
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Buscar modelo
     */
    protected function findModel($id)
    {
        if (($model = Laboratorios::find()
            ->completos()
            ->andWhere(['laboratorios.id' => $id])
            ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El laboratorio no existe.');
    }

    /**
     * Combo tipos
     */
    protected function getTipos()
    {
        return ArrayHelper::map(
            CatTiposLaboratorio::find()
                ->where(['activo' => 1])
                ->orderBy('nombre')
                ->all(),
            'id',
            'nombre'
        );
    }

    /**
     * Combo estados
     */
    protected function getEstados()
    {
        return ArrayHelper::map(
            CatEstadosLaboratorio::find()
                ->where(['activo' => 1])
                ->orderBy('nombre')
                ->all(),
            'id',
            'nombre'
        );
    }

    /**
     * Combo ubicaciones
     */
    protected function getUbicaciones()
    {
        $rows = Ubicaciones::find()
            ->orderBy(['edificio' => SORT_ASC, 'aula' => SORT_ASC])
            ->all();

        $data = [];

        foreach ($rows as $row) {
            $data[$row->id] =
                $row->edificio . ' / ' .
                $row->bloque . ' / ' .
                $row->piso . ' / ' .
                $row->aula;
        }

        return $data;
    }



private function getResponsables()
{
    return ArrayHelper::map(
        Usuarios::find()
            ->where([
                'estado' => 'activo',
                'rol_id' => 3
            ])
            ->orderBy(['nombre' => SORT_ASC])
            ->all(),
        'id',
        function ($u) {
            return trim(($u->nombre ?? '') . ' ' . ($u->apellido ?? ''));
        }
    );
}


} 