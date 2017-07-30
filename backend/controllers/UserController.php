<?php

namespace backend\controllers;

use yii;
use yii\web\Controller;
use backend\models\Users;
use yii\data\Pagination;



class UserController extends Controller
{
    public function actionIndex()
    {
        $this->view->blocks['content-header'] = 'Users Manager';
        $model = new Users();
        $query = $model->getCount();
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $pagination->setPageSize(5);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);
    }

    public function actionView(){
        return $this->render('view',['model'=>$this->FindModel()]);
    }

    public function actionCreate() {

    }

    public function actionDelete() {
        $this->FindModel()->delete();
        return $this->redirect('index');
    }

    public function actionUpdate() {
       if(Yii::$app->request->isAjax) {
            $id = ltrim(Yii::$app->request->post('id'),'f');
            $stt = Yii::$app->request->post('stt');
            $user  = Users::findOne($id);
            $user->status = $stt;
            if($user->save()) {
                return true;
            }else {
                return false;
            }
       }
    }



    public function FindModel(){
        $request = yii::$app->request->get();
        $id = $request['id'];
        $model = new Users ;

        if(($model = $model->getModel($id)) !== null) {
            return $model;
        }else {
            return 'Yêu cầu trang không tồn tại';
        }
    }

}
