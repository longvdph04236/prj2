<?php

namespace frontend\controllers;

use common\models\LoginForm;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->view->params['big-title'] = 'Hồ sơ người dùng';
        return $this->render('index');
    }

    public function actionDangNhap()
    {
        $model = new LoginForm();
        if(\Yii::$app->request->isAjax){
            return $this->renderAjax('login', [
                'model' => $model
            ]);
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionDangKy()
    {
        $this->view->params['big-title'] = 'Đăng ký';
        return $this->render('signup');
    }

}
