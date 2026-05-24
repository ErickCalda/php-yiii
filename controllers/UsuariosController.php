<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\models\Roles;

class UsuariosController extends Controller
{
public function behaviors()
{
    return [
        'access' => [
            'class' => AccessControl::class,
            'only' => [
                'index',
                'view',
                'create',
                'update',
                'delete',
                'perfil',
                'cambiar-password'
            ],
            'rules' => [

                // 🔴 SOLO ADMIN PUEDE VER INDEX
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'update', 'delete'],
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->user->identity->rol->nombre === 'admin';
                    },
                ],

                // 🟢 USUARIOS LOGUEADOS (SIN INDEX)
                [
                    'allow' => true,
                    'actions' => ['view', 'perfil', 'cambiar-password'],
                    'roles' => ['@'],
                ],

            ],
        ],
    ];
}

    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $isAdmin = !Yii::$app->user->isGuest
            && Yii::$app->user->identity->rol->nombre === 'admin';

        return $this->render('index', compact(
            'searchModel',
            'dataProvider',
            'isAdmin'
        ));
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Usuarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->identity->rol->nombre !== 'admin') {
            throw new ForbiddenHttpException('No autorizado.');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->rol->nombre !== 'admin') {
            throw new ForbiddenHttpException('No autorizado.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Usuario no encontrado.');
    }


public function actionPerfil()
{
    if (Yii::$app->user->isGuest) {
        throw new ForbiddenHttpException();
    }

    $model = Yii::$app->user->identity;

    return $this->render('perfil', [
        'model' => $model
    ]);
}



public function actionCambiarPassword()
{
    if (Yii::$app->user->isGuest) {
        throw new ForbiddenHttpException();
    }

    $model = Usuarios::findOne(Yii::$app->user->id);

    if (!$model) {
        throw new NotFoundHttpException('Usuario no encontrado');
    }

    if (Yii::$app->request->isPost) {

        $actual = Yii::$app->request->post('actual');
        $nueva = Yii::$app->request->post('nueva');
        $confirmar = Yii::$app->request->post('confirmar');

        // 🔐 validar clave actual
        if (!Yii::$app->security->validatePassword($actual, $model->clave)) {
            Yii::$app->session->setFlash('error', 'Contraseña actual incorrecta');
            return $this->refresh();
        }

        // 🔁 validar coincidencia
        if ($nueva !== $confirmar) {
            Yii::$app->session->setFlash('error', 'Las contraseñas no coinciden');
            return $this->refresh();
        }

        // 🔒 guardar nueva clave encriptada
        $model->clave = Yii::$app->security->generatePasswordHash($nueva);

        $model->save(false);

        Yii::$app->session->setFlash('success', 'Contraseña actualizada correctamente');
        return $this->refresh();
    }

    return $this->render('cambiar-password', [
        'model' => $model
    ]);
}





}