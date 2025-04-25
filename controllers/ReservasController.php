<?php



namespace app\controllers;

use Yii;
use app\models\Reservas;
use app\models\ReservasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Exception;


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
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Reservas models.
     *
     * @return string
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
     * Displays a single Reservas model.
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
     * Creates a new Reservas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
{
    $model = new Reservas();
    
    // Verifica si se cargó el formulario
    if ($model->load(Yii::$app->request->post())) {
        try {
            // Guardamos la reserva con el usuario seleccionado
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (\yii\db\Exception $e) {
            // Detectamos si el error es por solapamiento de horarios
            if (str_contains($e->getMessage(), 'se solapan')) {
                // Agregar error solo en el campo hora_inicio
                $model->addError('hora_inicio', 'Las horas se solapan con una reserva existente.');
            } else {
                throw $e; // Si es otro tipo de error, lo relanzamos
            }
        }
    }
    
    // Renderizamos la vista de creación
    return $this->render('create', [
        'model' => $model,
    ]);
}

    


    /**
     * Updates an existing Reservas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reservas model.
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
     * Finds the Reservas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reservas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    // controllers/ReservasController.php
public function actionHorario()
{
    // Obtener todas las reservas aprobadas
    $reservas = Reservas::find()->where(['estado' => 'aprobada'])->all();

    // Organiza las reservas por día
    $horario = [];
    foreach ($reservas as $reserva) {
        $dia = date('l', strtotime($reserva->fecha)); // Obtiene el día de la semana
        if (!isset($horario[$dia])) {
            $horario[$dia] = [];
        }
        $horario[$dia][] = $reserva;
    }

    // Renderiza la vista con los datos de las reservas
    return $this->render('horario', [
        'horario' => $horario,
    ]);
}










    
}
