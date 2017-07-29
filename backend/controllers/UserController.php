<?php

namespace backend\controllers;

use yii;
use yii\web\Controller;
use app\models\Users;
use yii\data\Pagination;



class UserController extends Controller
{
    public function actionIndex()
    {
        $this->view->blocks['content-header'] = 'adb';
        $model = new Users();
        $query = $model->getCount();
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $pagination->setPageSize(1);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);
    }

}
