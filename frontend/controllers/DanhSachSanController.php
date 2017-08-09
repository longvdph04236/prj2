<?php

namespace frontend\controllers;
use common\models\Stadiums;
Use yii\data\Pagination;

class DanhSachSanController extends \yii\web\Controller
{
    public function actionIndex()
    {


        $this->view->params['big-title'] = 'Danh sách sân';
        $query = Stadiums::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $pagination->setPageSize(5);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);

    }

}
