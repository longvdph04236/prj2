<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\ActivateForm;
use frontend\models\SignupForm;
use frontend\models\UserProfileForm;
use Yii;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\UploadedFile;

class UserController extends \yii\web\Controller
{
    public function actionFb(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            $fullName = Yii::$app->request->post('name');
            $email = Yii::$app->request->post('email');
            $ava = Yii::$app->request->post('ava');
            $user = User::findOne(['fid'=>$id]);
            if(isset($user)){
                Yii::$app->user->login($user);
                return true;
            } else {
                Yii::$app->session->setFlash('uid',$id);
                Yii::$app->session->setFlash('fn',$fullName);
                Yii::$app->session->setFlash('em',$email);
                Yii::$app->session->setFlash('ava',$ava);
                return false;
            }
        }
    }

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $this->view->params['big-title'] = 'Hồ sơ người dùng';
        $userModel = User::findOne(Yii::$app->user->identity->getId());

        $upForm = new UserProfileForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if(isset($post['profile-update-button'])){
                if($userModel->load(Yii::$app->request->post())){
                    $userModel->newPhoto = UploadedFile::getInstance($userModel,'newPhoto');
                    if($userModel->validate()){
                        if (isset($userModel->newPhoto->extension)) {
                            $timeMarker = str_replace(" ", "_", microtime());
                            $filename = $userModel->newPhoto->baseName . $timeMarker .'.'. $userModel->newPhoto->extension;
                            $userModel->newPhoto->saveAs(Yii::$app->params['appPath'].'/uploads/images/' . $filename);
                            $userModel->avatar = $filename;
                            $userModel->newPhoto = null;
                        }
                        $userModel->save();
                        Yii::$app->session->setFlash('s','Thông tin đã được cập nhật thành công');
                        return $this->redirect(['user/index']);
                    }
                }
            }
        }
        return $this->render('index',['model'=>$userModel,'upForm'=>$upForm]);
    }

    public function actionDangNhap()
    {
        $model = new LoginForm();
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->login()){
                return $this->goHome();
            }
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
            //var_dump($model);die;
            if ($user = $model->signup()) {
                if(Yii::$app->getUser()->login($user)){
                    $phone = $user->phone;
                    $code = mt_rand(0,9999);
                    $code = str_pad((string)$code,4, "0", STR_PAD_LEFT);
                    $mess = "Code kich hoat: ".$code;
                    $sent = $this->smsTo($phone,$mess);
                    //var_dump($sent);die;
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
                        var_dump($sent);die;
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
        $username = "84963468110";
        $password = "7124";
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

