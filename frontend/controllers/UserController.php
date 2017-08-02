<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\ActivateForm;
use frontend\models\SignupForm;
use frontend\models\ResetPasswordForm;
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
<<<<<<< Updated upstream
=======

    public function actionDangXuat() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionResend(){
        if(Yii::$app->request->isAjax){
            $user = User::findIdentity(Yii::$app->user->identity);
            $code = mt_rand(0,9999);
            $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
            $mess = "Code kich hoat: ".$code;
            $phone = $user->phone;
            if($this->smsTo($phone,$mess) == 'OK'){
                date_default_timezone_set('Asia/Bangkok');
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'otp',
                    'value' => Yii::$app->security->generatePasswordHash($code),
                    'expire' => time() + 5*60
                ]));
                return true;
            } else {
                die('Không gửi được sms, hết tiền');
            }
        } else {
            return $this->goHome();
        }
    }

    private function smsTo($phone, $mess){
        $username = "84981830492";
        $password = "2354";
        $mobile = $phone;
        $sender = "YeuBongDa";
        $message = $mess;
        $url = "http://sendpk.com/api/sms.php?username=".$username."&password=".$password."&mobile=".$mobile."&sender=".urlencode($sender)."&message=".urlencode($message)."";

        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $responce = curl_exec($ch);
        curl_close($ch);
        $res = explode(' ',$responce);
        return $res[0];
    }

    public function actionRequestPasswordReset()
    {
        $this->view->params['big-title'] = 'Lấy lại Mật khẩu';
        $model = new ResetPasswordForm();
        return $this->render('sendphone',['model'=>$model]);
    }
>>>>>>> Stashed changes
}

