<?php

namespace backend\controllers;

use common\models\Comments;
use common\models\Stadiums;
use yii\data\Pagination;

class CommentsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->view->blocks['content-header'] = 'Quản lý bình luận';
        $model = new Comments();
        $query = $model->find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $pagination->setPageSize(5);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);
    }

    public function actionDelete($id) {
        $comment = Comments::findOne($id);
        $rate = $comment->rate;
        $stadium = $comment->field;
        if($comment->delete()){
            $stadium->rate -= $rate;
            $stadium->count_rate -= 1;
            $stadium->save();
        }
        return $this->redirect('index');
    }

}
