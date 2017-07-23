<?php

namespace frontend\controllers;

class HomeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'homepage';
        return $this->render('index');
    }
}
