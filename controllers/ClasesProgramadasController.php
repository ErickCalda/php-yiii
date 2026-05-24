<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\ClasesProgramadas;
use app\models\ClasesProgramadasSearch;
use app\models\Laboratorios;
use app\models\Usuarios;
use app\models\Materias;
use app\models\Cursos;
use app\models\PeriodosAcademicos;

class ClasesProgramadasController extends Controller
{
 

 const ESTADO_PROGRESO = 0;
    const ESTADO_ACTIVO = 1;
    const ESTADO_CANCELADO = 2;


public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,

            // 🔥 IMPORTANTE
            'only' => [
                'index',
                'view',
                'create',
                'update',
                'delete',
                'check-horario'
            ],

            'rules' => [

                /* =========================
                   VER LISTADO / VER DETALLE
                ========================= */
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['index', 'view'],
                ],

                /* =========================
                   CREAR
                ========================= */
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['create'],
                ],

                /* =========================
                   EDITAR
                ========================= */
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['update'],
                ],

                /* =========================
                   AJAX VALIDAR HORARIO
                ========================= */
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['check-horario'],
                ],

                /* =========================
                   ELIMINAR SOLO ADMIN
                ========================= */
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'actions' => ['delete'],

                    'matchCallback' => fn() =>
                        Yii::$app->user->identity->rol_id
                        == Usuarios::ROL_ADMIN
                ],
            ],

            /* =========================
               SI NO TIENE PERMISO
            ========================= */
            'denyCallback' => function () {
                throw new \yii\web\ForbiddenHttpException(
                    'No tienes permisos para acceder.'
                );
            }
        ],

        /* =========================
           VERB FILTER
        ========================= */
        'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
                'check-horario' => ['POST'],
            ],
        ],
    ];
}

    /* =========================
       INDEX
    ========================= */
/* =========================
   INDEX (ADMIN VE TODO /
   DOCENTE SOLO SUS HORAS)
   REEMPLAZA TU actionIndex()
========================= */
public function actionIndex()
{
    $searchModel = new ClasesProgramadasSearch();

    $dataProvider = $searchModel->search(
        Yii::$app->request->queryParams
    );

    $query = $dataProvider->query;

    $usuario = Yii::$app->user->identity;

    /* =========================
       SI NO ES ADMIN
    ========================= */
    if ($usuario->rol_id != Usuarios::ROL_ADMIN) {

        /* SOLO CLASES DEL DOCENTE */
        $query->andWhere([
            'docente_id' => $usuario->id
        ]);
    }

    /* =========================
       ORDEN BONITO HORARIO
    ========================= */
$query->orderBy([
    new \yii\db\Expression("
        FIELD(
            dia_semana,
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado'
        )
    "),
    'hora_inicio' => SORT_ASC
]);

    /* SIN PAGINACIÓN */
    $dataProvider->pagination = false;

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    /* =========================
       VIEW
    ========================= */
public function actionView($id)
{
    $model = $this->findModel($id);

    if (!$model->puedeGestionar()) {
        throw new \yii\web\ForbiddenHttpException(
            'No tienes permisos.'
        );
    }

    return $this->render('view', [
        'model' => $model,
    ]);
}

    /* =========================
       CREATE
    ========================= */
public function actionCreate()
{
    $model = new ClasesProgramadas();

    /* 🔥 FIX: asignar docente automáticamente si no es admin */
    $usuario = Yii::$app->user->identity;

    if ($usuario->rol_id != Usuarios::ROL_ADMIN) {
        $model->docente_id = $usuario->id;
    }

    if ($model->load(Yii::$app->request->post())) {

        if ($this->validarReserva($model)) {

            if ($model->save()) {

                Yii::$app->session->setFlash(
                    'success',
                    'Clase programada correctamente.'
                );

                return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash(
                'error',
                'No se pudo guardar la clase. Revise los campos.'
            );
        } else {

            Yii::$app->session->setFlash(
                'warning',
                'Existen conflictos en la reserva.'
            );
        }
    }

    return $this->render('create', [
        'model' => $model,
        'listas' => $this->getListas(),
    ]);
}




public function actionUpdate($id)
{
    $model = $this->findModel($id);

    /* 🔥 FIX: asegurar docente visible correctamente */
    $usuario = Yii::$app->user->identity;

    if ($usuario->rol_id != Usuarios::ROL_ADMIN && empty($model->docente_id)) {
        $model->docente_id = $usuario->id;
    }

    if (!$model->puedeGestionar()) {

        $mensaje = (
            $usuario->rol_id == Usuarios::ROL_DOCENTE
        )
            ? 'El tiempo permitido para editar esta reserva ya expiró.'
            : 'No tienes permisos para editar este registro.';

        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format =
                \yii\web\Response::FORMAT_JSON;

            return [
                'ok' => false,
                'message' => $mensaje
            ];
        }

        throw new \yii\web\ForbiddenHttpException($mensaje);
    }

    if ($model->load(Yii::$app->request->post())) {

        if ($this->validarReserva($model, $model->id)) {

            if ($model->save()) {

                if (Yii::$app->request->isAjax) {

                    Yii::$app->response->format =
                        \yii\web\Response::FORMAT_JSON;

                    return [
                        'ok' => true,
                        'message' => 'Clase actualizada correctamente.'
                    ];
                }

                return $this->redirect(['index']);
            }
        }

        if (Yii::$app->request->isAjax) {

            Yii::$app->response->format =
                \yii\web\Response::FORMAT_JSON;

            $errores = $model->getFirstErrors();

            return [
                'ok' => false,
                'message' => reset($errores)
            ];
        }
    }

    return $this->render('update', [
        'model' => $model,
        'listas' => $this->getListas(),
    ]);
}






public function actionDelete($id)
{
    Yii::$app->response->format =
        \yii\web\Response::FORMAT_JSON;

    try{

        $model = $this->findModel($id);

        if(!$model->puedeGestionar()){

            return [
                'ok' => false,
                'message' => 'No tienes permisos para eliminar.'
            ];

        }

        if($model->delete()){

            return [
                'ok' => true,
                'message' => 'Clase eliminada correctamente.'
            ];

        }

        return [
            'ok' => false,
            'message' => 'No se pudo eliminar.'
        ];

    }catch(\Throwable $e){

        Yii::error($e->getMessage(), 'DELETE_ERROR');

        return [
            'ok' => false,
            'message' => 'Error interno del servidor.'
        ];

    }
}

    /* =========================
       🔥 MOTOR DE RESERVAS REAL
    ========================= */
private function validarReserva($model, $ignoreId = null)
{
    /* =========================
       VALIDACIÓN DE HORAS
    ========================= */
    if (!$model->hora_inicio || !$model->hora_fin) {
        $model->addError(
            'hora_inicio',
            'Horas obligatorias.'
        );
        return false;
    }

    if ($model->hora_inicio >= $model->hora_fin) {
        $model->addError(
            'hora_fin',
            'La hora fin debe ser mayor.'
        );
        return false;
    }

    /* =========================
       BUSCAR RESERVAS QUE BLOQUEAN
       0 = En progreso
       1 = Activo
       2 = Cancelado (NO BLOQUEA)
    ========================= */
    $query = ClasesProgramadas::find()
        ->where([
            'dia_semana' => $model->dia_semana,
        ])
        ->andWhere([
            'in',
            'estado',
            [0, 1]
        ]);

    /* IGNORAR MISMO REGISTRO AL EDITAR */
    if ($ignoreId) {
        $query->andWhere([
            '<>',
            'id',
            $ignoreId
        ]);
    }

    /* =========================
       DETECTAR SOLAPAMIENTO
    ========================= */
    $query->andWhere([
        'or',

        // Inicio dentro de una reserva existente
        [
            'and',
            ['<=', 'hora_inicio', $model->hora_inicio],
            ['>', 'hora_fin', $model->hora_inicio],
        ],

        // Fin dentro de una reserva existente
        [
            'and',
            ['<', 'hora_inicio', $model->hora_fin],
            ['>=', 'hora_fin', $model->hora_fin],
        ],

        // La nueva reserva encapsula otra
        [
            'and',
            ['>=', 'hora_inicio', $model->hora_inicio],
            ['<=', 'hora_fin', $model->hora_fin],
        ],
    ]);

    /* =========================
       VALIDAR LABORATORIO
    ========================= */
    if (
        (clone $query)
        ->andWhere([
            'laboratorio_id' => $model->laboratorio_id
        ])
        ->exists()
    ) {
        $model->addError(
            'laboratorio_id',
            'Laboratorio ocupado en ese horario.'
        );

        return false;
    }

    /* =========================
       VALIDAR DOCENTE
    ========================= */
    if (
        (clone $query)
        ->andWhere([
            'docente_id' => $model->docente_id
        ])
        ->exists()
    ) {
        $model->addError(
            'docente_id',
            'Docente ocupado en ese horario.'
        );

        return false;
    }

    /* =========================
       VALIDAR CURSO
    ========================= */
    if (
        (clone $query)
        ->andWhere([
            'curso_id' => $model->curso_id
        ])
        ->exists()
    ) {
        $model->addError(
            'curso_id',
            'Curso ocupado en ese horario.'
        );

        return false;
    }

    /* =========================
       VALIDAR PERIODO
    ========================= */
    $periodo = PeriodosAcademicos::findOne(
        $model->periodo_id
    );

    if (!$periodo || !$periodo->activo) {

        $model->addError(
            'periodo_id',
            'Periodo no activo.'
        );

        return false;
    }

    return true;
}

    /* =========================
       LISTAS FORM
    ========================= */
    private function getListas()
    {
        return [
            'laboratorios' => Laboratorios::find()->select(['nombre','id'])->indexBy('id')->column(),

            'docentes' => Usuarios::find()
                ->where(['rol_id' => Usuarios::ROL_DOCENTE])
                ->select(['id', 'nombre', 'apellido'])
                ->all(),

            'materias' => Materias::find()->select(['nombre','id'])->indexBy('id')->column(),

            'cursos' => Cursos::find()->select(['nombre','id'])->indexBy('id')->column(),

            'periodos' => PeriodosAcademicos::find()
                ->where(['activo' => 1])
                ->select(['nombre','id'])
                ->indexBy('id')
                ->column(),
        ];
    }

    /* =========================
       FIND
    ========================= */
    protected function findModel($id)
    {
        if (($model = ClasesProgramadas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('No encontrado.');
    }



public function actionCheckHorario()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $model = new ClasesProgramadas();

    $model->laboratorio_id = Yii::$app->request->post('laboratorio_id');
    $model->docente_id     = Yii::$app->request->post('docente_id');
    $model->curso_id       = Yii::$app->request->post('curso_id');
    $model->dia_semana     = Yii::$app->request->post('dia_semana');
    $model->hora_inicio    = Yii::$app->request->post('hora_inicio');
    $model->hora_fin       = Yii::$app->request->post('hora_fin');
    $model->periodo_id     = Yii::$app->request->post('periodo_id');

    if ($this->validarReserva($model)) {
        return [
            'ok' => true,
            'msg' => '✅ Horario disponible'
        ];
    }

    $errores = $model->getFirstErrors();

    return [
        'ok' => false,
        'msg' => reset($errores)
    ];
}




public function actionGetHorasDisponibles()
{
    Yii::$app->response->format =
        \yii\web\Response::FORMAT_JSON;

    $lab = Yii::$app->request->post('laboratorio_id');
    $dia = Yii::$app->request->post('dia_semana');
    $periodo = Yii::$app->request->post('periodo_id');

    if (!$lab || !$dia || !$periodo) {
        return [
            'ok' => false,
            'horas' => []
        ];
    }

    /* =========================
       HORAS BASE
    ========================= */
    $horas = [];

    for ($h = 7; $h <= 17; $h++) {

        // Saltar almuerzo
        if ($h == 12) {
            continue;
        }

        $horas[] = sprintf('%02d:00', $h);
        $horas[] = sprintf('%02d:30', $h);
    }

    /* =========================
       RESERVAS QUE BLOQUEAN
       0 = En progreso
       1 = Activo
    ========================= */
    $reservas = ClasesProgramadas::find()
        ->where([
            'laboratorio_id' => $lab,
            'dia_semana' => $dia,
            'periodo_id' => $periodo,
        ])
        ->andWhere([
            'in',
            'estado',
            [0, 1]
        ])
        ->all();

    /* =========================
       CALCULAR HORAS OCUPADAS
    ========================= */
    $ocupadas = [];

    foreach ($reservas as $r) {

        $inicioReserva =
            strtotime(substr($r->hora_inicio, 0, 5));

        $finReserva =
            strtotime(substr($r->hora_fin, 0, 5));

        foreach ($horas as $hora) {

            $horaActual =
                strtotime($hora);

            if (
                $horaActual >= $inicioReserva &&
                $horaActual < $finReserva
            ) {
                $ocupadas[] = $hora;
            }
        }
    }

    /* =========================
       HORAS DISPONIBLES
    ========================= */
    $disponibles = array_values(
        array_diff(
            $horas,
            array_unique($ocupadas)
        )
    );

    return [
        'ok' => true,
        'horas' => $disponibles
    ];
}



public function actionImprimirHorario($docente_id = null)
{
    $searchModel = new ClasesProgramadasSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $query = $dataProvider->query;

    $usuario = Yii::$app->user->identity;

    /* =========================
       SOLO ACTIVOS
    ========================= */
$query->andWhere(['clases_programadas.estado' => 1]);

    /* =========================
       SEGURIDAD: CONTROL DE ACCESO
    ========================= */
    if ($usuario->rol_id != Usuarios::ROL_ADMIN) {

        // docente solo ve lo suyo
        $query->andWhere(['docente_id' => $usuario->id]);

    } else {

        // admin puede filtrar por docente
        if ($docente_id) {
            $query->andWhere(['docente_id' => $docente_id]);
        }
    }

    /* =========================
       ORDENAMIENTO DE HORARIO
    ========================= */
    $query->orderBy([
        new \yii\db\Expression("
            FIELD(
                dia_semana,
                'lunes','martes','miercoles',
                'jueves','viernes','sabado'
            )
        "),
        'hora_inicio' => SORT_ASC
    ]);

    return $this->renderPartial('imprimir-horario', [
        'dataProvider' => $dataProvider,
        'usuario' => $usuario,
    ]);
}


}