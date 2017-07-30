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
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
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
            $user = User::findIdentity(Yii::$app->user->identity);
            if($user->getStatus() == 'activated'){
                return $this->goHome();
            } else {
                return $this->redirect(['user/kich-hoat', 'u' => $user->accessToken]);
            }
        }
        $this->view->params['big-title'] = 'Đăng ký';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if(Yii::$app->getUser()->login($user)){
                    $phone = $user->phone;
                    $code = mt_rand(0,9999);
                    $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
                    $mess = "Code kich hoat: ".$code;
                    $sent = $this->smsTo($phone,$mess);
                    if($sent == 'OK'){
                        $cookies =  Yii::$app->response->cookies;
                        date_default_timezone_set('Asia/Bangkok');
                        $ci = new Cookie([
                            'name' => 'otp',
                            'value' => Yii::$app->security->generatePasswordHash($code),
                            'expire' => time() + 5*60
                        ]);
                        $cookies->add($ci);
                    } else {
                        var_dump($sent);
                    }

                    return $this->redirect(['user/kich-hoat','u'=>$user->accessToken]);
                }
            }
        }
        return $this->render('signup', ['model' => $model]);
    }

    public function actionKichHoat()
    {
        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ActivateForm();
        $this->view->params['big-title'] = 'Kích hoạt tài khoản';
        $user = User::findOne(Yii::$app->user->identity->getId());
        if ($model->load(Yii::$app->request->post())) {
            if($model->aT == $user->accessToken){
                if(Yii::$app->request->cookies->get('otp')){
                    if(Yii::$app->security->validatePassword($model->otp,Yii::$app->request->cookies->getValue('otp'))){
                        $user->accessToken = null;
                        $user->status = 'activated';
                        if($user->save()){
                            Yii::$app->session->setFlash('activeS', 'Bạn đã kích hoạt thành công tài khoản');
                            Yii::$app->response->cookies->remove('otp');
                            return Yii::$app->response->redirect(['home/index']);
                        } else {
                            echo('Can\'t save'); die;
                        }
                    } else {
                        //Yii::$app->session->setFlash('ckwrong', 'Mã không chính xác.');
                        $model->addError('otp','Mã không chính xác.');
                    }
                } else {
                    //Yii::$app->session->setFlash('ckend', 'Mã đã hết hạn. Vui lòng lấy mã mới.');
                    $model->addError('otp','Mã đã hết hạn. Vui lòng lấy mã mới.');
                }
            } else {
                echo 'Người dùng không hợp lệ'; die;
            }
        }

        return $this->render('activate', ['model' => $model]);

    }

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
}

