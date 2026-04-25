<?php

namespace app\controllers;

use Yii;
use app\models\Reservas;
use app\models\ReservasSearch;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ReservasController implements the CRUD actions for Reservas model.
 */
class ReservasController extends Controller
{
    /**
     * @inheritDoc
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
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest &&
                                Yii::$app->user->identity->rol_id == Usuarios::ROL_ADMIN;
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * Lista reservas
     */
    public function actionIndex()
    {
        $searchModel = new ReservasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Ver reserva
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crear reserva
     */
public function actionCreate()
{
    $model = new Reservas();

    $hayUsuarios = Usuarios::find()
        ->where(['estado' => 'activo'])
        ->andWhere(['!=', 'rol_id', Usuarios::ROL_ADMIN])
        ->exists();

    if (!$hayUsuarios) {
        Yii::$app->session->setFlash(
            'warning',
            'No existen usuarios disponibles para reservar.'
        );

        return $this->redirect(['index']);
    }

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Reserva creada correctamente.');
        return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('create', [
        'model' => $model,
    ]);
}

    /**
     * Editar reserva
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost &&
            $model->load($this->request->post()) &&
            $model->save()) {

            Yii::$app->session->setFlash(
                'success',
                'Reserva actualizada correctamente.'
            );

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Eliminar reserva
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash(
            'success',
            'Reserva eliminada correctamente.'
        );

        return $this->redirect(['index']);
    }

    /**
     * Horario general
     */
    public function actionHorario()
    {
        $reservas = Reservas::find()
            ->where(['estado' => ['aprobada', 'pendiente']])
            ->all();

        $horario = [];

        foreach ($reservas as $reserva) {
            $dia = date('l', strtotime($reserva->fecha));

            if (!isset($horario[$dia])) {
                $horario[$dia] = [];
            }

            $horario[$dia][] = $reserva;
        }

        return $this->render('horario', [
            'horario' => $horario,
        ]);
    }

    /**
     * Buscar modelo
     */
    protected function findModel($id)
    {
        if (($model = Reservas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            Yii::t('app', 'The requested page does not exist.')
        );
    }
}