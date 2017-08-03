<?php

namespace frontend\controllers;

class TimDoiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->view->params['big-title'] = 'Tìm Đối';
        return $this->render('index');
    }


}
