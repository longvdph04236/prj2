<?php

namespace frontend\controllers;

class VeChungToiController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'about';
        $this->view->params['big-title'] = 'Về Chúng Tôi';
        return $this->render('index');
    }

}
