<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\ActivateForm;
use frontend\models\SignupForm;
use Yii;
use yii\web\Cookie;

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
        if(!Yii::$app->user->isGuest) {
            //return $this->goHome();
        }
        $this->view->params['big-title'] = 'Đăng ký';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                //$identity = User::findOne($user->getId());
                if (Yii::$app->user->login($user,3600*24*30)) {
                    //var_dump(Yii::$app->user->identity); die;
                    return $this->redirect(['user/kich-hoat','u'=>$user->accessToken]);
                } else {
                    echo 'F';
                }
            } else {
                var_dump($user);
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionKichHoat()
    {
        if(Yii::$app->user->isGuest) {
            //return $this->goHome();
        }
        $model = new ActivateForm();
        $this->view->params['big-title'] = 'Kích hoạt tài khoản';
        var_dump(Yii::$app->user->identity); die;
        $user = User::findOne(Yii::$app->user->identity->getId());
        $phone = $user->phone;
        $code = mt_rand(0,9999);
        $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
        $mess = "Code kich hoat: ".$code;
        Yii::$app->sms->send($phone, $mess);
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'otp',
            'value' => Yii::$app->security->generatePasswordHash($code),
            'expire' => 5 * 60 * 1000
        ]));
        return $this->render('activate', ['model' => $model]);

    }
}

