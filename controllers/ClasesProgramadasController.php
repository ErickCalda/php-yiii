<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;

use app\models\ClasesProgramadas;
use app\models\ClasesProgramadasSearch;
use app\models\Laboratorios;
use app\models\Usuarios;
use app\models\Materias;
use app\models\Cursos;
use app\models\PeriodosAcademicos;

class ClasesProgramadasController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [

                    // ADMIN / DOCENTE / TECNICO
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view'],
                    ],

                    // ADMIN / DOCENTE / TECNICO crean
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['create'],
                        'matchCallback' => function () {
                            return in_array(
                                (int) Yii::$app->user->identity->rol_id,
                                [
                                    Usuarios::ROL_ADMIN,
                                    Usuarios::ROL_DOCENTE,
                                    Usuarios::ROL_TECNICO
                                ]
                            );
                        }
                    ],

                    // ADMIN / TECNICO editan
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['update'],
                        'matchCallback' => function () {
                            return in_array(
                                (int) Yii::$app->user->identity->rol_id,
                                [
                                    Usuarios::ROL_ADMIN,
                                    Usuarios::ROL_TECNICO
                                ]
                            );
                        }
                    ],

                    // SOLO ADMIN elimina
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['delete'],
                        'matchCallback' => function () {
                            return (int) Yii::$app->user->identity->rol_id
                                === (int) Usuarios::ROL_ADMIN;
                        }
                    ],
                ],
                'denyCallback' => function () {
                    throw new \yii\web\ForbiddenHttpException('Sin permisos.');
                }
            ],

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /* ==================================================
       INDEX
    ================================================== */
    public function actionIndex()
    {
        $searchModel = new ClasesProgramadasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /* ==================================================
       VIEW
    ================================================== */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /* ==================================================
       CREATE
    ================================================== */
    public function actionCreate()
    {
        $model = new ClasesProgramadas();

        if ($model->load(Yii::$app->request->post())) {

            if ($this->existeCruceHorario($model)) {
                $model->addError(
                    'hora_inicio',
                    'Ya existe una clase programada en ese horario.'
                );
            }

            if (!$model->hasErrors() && $model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Clase programada correctamente.'
                );

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listas' => $this->getListas(),
        ]);
    }

    /* ==================================================
       UPDATE
    ================================================== */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($this->existeCruceHorario($model, $model->id)) {
                $model->addError(
                    'hora_inicio',
                    'Ese horario ya está ocupado.'
                );
            }

            if (!$model->hasErrors() && $model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Clase actualizada.'
                );

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'listas' => $this->getListas(),
        ]);
    }

    /* ==================================================
       DELETE
    ================================================== */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash(
            'success',
            'Clase eliminada.'
        );

        return $this->redirect(['index']);
    }

    /* ==================================================
       LISTAS PARA FORM
    ================================================== */
    private function getListas()
    {
        return [

            'laboratorios' => ArrayHelper::map(
                Laboratorios::find()
                    ->orderBy('nombre')
                    ->all(),
                'id',
                'nombre'
            ),

            'docentes' => ArrayHelper::map(
                Usuarios::find()
                    ->where([
                        'rol_id' => Usuarios::ROL_DOCENTE
                    ])
                    ->orderBy('nombre')
                    ->all(),
                'id',
                function ($u) {
                    return $u->nombre . ' ' . $u->apellido;
                }
            ),

            'materias' => ArrayHelper::map(
                Materias::find()
                    ->orderBy('nombre')
                    ->all(),
                'id',
                'nombre'
            ),

            'cursos' => ArrayHelper::map(
                Cursos::find()
                    ->orderBy('nombre')
                    ->all(),
                'id',
                'nombre'
            ),

            'periodos' => ArrayHelper::map(
                PeriodosAcademicos::find()
                    ->where(['activo' => 1])
                    ->all(),
                'id',
                'nombre'
            ),
        ];
    }

    /* ==================================================
       VALIDAR CHOQUE HORARIO
    ================================================== */
    private function existeCruceHorario($model, $ignoreId = null)
    {
        $query = ClasesProgramadas::find()
            ->where([
                'laboratorio_id' => $model->laboratorio_id,
                'dia_semana' => $model->dia_semana,
                'estado' => 1
            ])
            ->andWhere([
                '<',
                'hora_inicio',
                $model->hora_fin
            ])
            ->andWhere([
                '>',
                'hora_fin',
                $model->hora_inicio
            ]);

        if ($ignoreId) {
            $query->andWhere(['<>', 'id', $ignoreId]);
        }

        return $query->exists();
    }

    /* ==================================================
       FIND MODEL
    ================================================== */
    protected function findModel($id)
    {
        if (($model = ClasesProgramadas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(
            'Registro no encontrado.'
        );
    }
}