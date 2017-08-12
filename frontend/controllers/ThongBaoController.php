<?php

namespace frontend\controllers;

use common\models\Schedule;
use common\models\Stadiums;
use common\models\User;
use yii\data\Pagination;

class ThongBaoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $user = User::findOne(\Yii::$app->user->identity->getId());
        if($user->type == 'manager'){
            $stadiums = Stadiums::findAll(['manager_id'=>$user->id]);
            $fid = array();
            foreach ($stadiums as $stadium){
                $fields = $stadium['fields'];
                foreach ($fields as $field){
                    $fid[] = $field['id'];
                }
            }

            $query = Schedule::find()->where(['in','field_id',$fid])->orderBy('status');
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count,'pageSize'=>10]);
            $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        } else {
            $query = Schedule::find()->where(['user_id'=>$user->id])->orderBy('status');
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count,'pageSize'=>10]);
            $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }
        $this->view->params['big-title'] = 'Thông báo đặt sân';
        return $this->render('index',['model'=>$articles,'pagi'=>$pagination]);
    }

    public function actionAccept(){
        if(\Yii::$app->request->isAjax){
            $sch = Schedule::findOne(\Yii::$app->request->post('v'));
            $sch->tracking_code = \Yii::$app->security->generateRandomString(6);
            $sch->status = 'success';
            if($sch->save()){
                return $sch->tracking_code;
            }
        }
    }

}
