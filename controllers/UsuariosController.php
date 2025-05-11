<?php

namespace app\controllers;
use Yii;  
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * @inheritDoc
     */
   
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::class,
                 'only' => ['create', 'update', 'delete', 'index', 'view'], // acciones protegidas
                 'rules' => [
                     // Regla para permitir acceso completo solo al admin
                     [
                         'allow' => true,
                         'actions' => ['create', 'update', 'delete'],
                         'roles' => ['@'], // autenticado
                         'matchCallback' => function ($rule, $action) {
                             return Yii::$app->user->identity->rol === \app\models\Usuarios::ROL_ADMIN;
                         },
                     ],
                     // Regla para permitir a cualquier usuario autenticado ver (index, view)
                     [
                         'allow' => true,
                         'actions' => ['index', 'view'],
                         'roles' => ['@'],
                     ],
                 ],
             ],
         ];
     }
 
    /**
     * Lists all Usuarios models.
     *
     * @return string
     */
    public function actionIndex()
{


    
    $searchModel = new UsuariosSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

  
    // Verificar si el usuario está autenticado
    $isAdmin = false;
    if (!Yii::$app->user->isGuest) {
        $isAdmin = Yii::$app->user->identity->rol === Usuarios::ROL_ADMIN;
    }

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'isAdmin' => $isAdmin, // Pasar el rol a la vista
    ]);
}

    /**
     * Displays a single Usuarios model.
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
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
/* 
         if (Yii::$app->user->isGuest) {
        // Redirigir al login si no hay sesión activa
        return $this->redirect(['site/login']);
    }
 */

      /*   if (Yii::$app->user->identity->role === 'laboratorista') {
            throw new ForbiddenHttpException('No tienes permiso para crear usuarios.');
        } */
        $model = new Usuarios();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (Yii::$app->user->identity->rol === 'laboratorista') {
            throw new ForbiddenHttpException('No tienes permiso para actualizar usuarios.');
        }
    
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->rol === 'laboratorista') {
            throw new ForbiddenHttpException('No tienes permiso para actualizar usuarios.');
        }
    
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
