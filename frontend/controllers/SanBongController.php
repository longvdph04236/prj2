<?php

namespace frontend\controllers;

use common\models\Stadiums;
use yii\widgets\NameToLink;

class SanBongController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $this->layout = 'sanbong';
        $p = explode('/',ltrim($_SERVER["REQUEST_URI"],'/'))[2];
        $stadium = Stadiums::findOne($id);
        if(count(explode('-',$p)) ==1){
            $arr = array_merge([$id],explode(' ',$stadium['name']));
            NameToLink::$name = implode('-',$arr);
            $link = NameToLink::run();
            return $this->redirect(['san-bong/'.$link]);
        }

        $this->view->params['big-title'] = $stadium['name'];
        $this->view->params['location'] = $stadium['address'];
        $info['district'] = $stadium->district->name;
        $info['city'] = $stadium->district->city->name;
        $info['stadium'] = $stadium;
        return $this->render('index', ['info'=>$info]);
    }

}
