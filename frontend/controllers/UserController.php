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
                if(Yii::$app->getUser()->login($user)){
                    return $this->redirect(['user/kich-hoat','u'=>$user->accessToken]);
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
                            return Yii::$app->response->redirect('home/');
                        } else {
                            echo('Can\'t save'); die;
                        }
                    } else {
                        Yii::$app->session->setFlash('ckwrong', 'Mã không chính xác.');
                        return false;
                    }
                } else {
                    Yii::$app->session->setFlash('ckend', 'Mã đã hết hạn. Vui lòng lấy mã mới.');
                    return false;
                }
            } else {
                echo 'Người dùng không hợp lệ'; die;
            }
        }
        $phone = $user->phone;
        $code = mt_rand(0,9999);
        $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
        $mess = "Code kich hoat: ".$code;
        if($this->smsTo($phone,$mess) == 'OK'){
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'otp',
                'value' => Yii::$app->security->generatePasswordHash($code),
                'expire' => 5 * 60 * 1000
            ]));
        }

        return $this->render('activate', ['model' => $model]);

    }

    public function actionResend(){
        if(Yii::$app->request->isAjax){
            $user = User::findIdentity(Yii::$app->user->identity);
            $code = mt_rand(0,9999);
            $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
            $mess = "Code kich hoat: ".$code;
            $phone = $user->phone;
            if($this->smsTo($phone,$mess) == 'OK'){
                Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'otp',
                    'value' => Yii::$app->security->generatePasswordHash($code),
                    'expire' => 5 * 60 * 1000
                ]));
                return true;
            } else {
                die('Không gửi được sms, hết tiền');
            }
        } else {
            return false;
        }
    }

    private function smsTo($phone, $mess){
        $username = "841643959003";
        $password = "8214";
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

