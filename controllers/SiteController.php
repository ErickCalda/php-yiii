<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuarios;
use app\models\LoginForm;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],  // Solo aplica en la acción 'logout'
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],  // Solo usuarios autenticados
                    ],
                ],
            ],
        ];
    }

    

    /**
     * Acción de inicio de sesión
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
    
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['usuarios/index']);
        }
    
        $model->clave = ''; // Limpia el campo clave por seguridad
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * Acción de logout
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();  // Cierra la sesión
        return $this->goHome();  // Redirige a la página de inicio
    }

    /**
     * Acción de inicio de página
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
{
    $exception = Yii::$app->errorHandler->exception;
    if ($exception !== null) {
        return $this->render('error', ['exception' => $exception]);
    }
}

    
}
