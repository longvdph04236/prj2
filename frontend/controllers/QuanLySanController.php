<?php

namespace frontend\controllers;

class QuanLySanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->view->params['big-title'] = "Quản lý sân bóng";
        return $this->render('index');
    }

}
