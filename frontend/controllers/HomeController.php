<?php

namespace frontend\controllers;

use common\models\User;
use Yii;


class HomeController extends \yii\web\Controller
{

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $user = User::findOne(Yii::$app->user->identity->getId());
            if($user->status != 'activated'){
                return $this->redirect(['user/kich-hoat','u'=>$user->accessToken]);
            }
        }
        $this->layout = 'homepage';
        return $this->render('index');
    }


}
