<?php

namespace frontend\controllers;

use common\models\Schedule;
use common\models\Stadiums;
use common\models\User;
use Yii;
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

            $query = Schedule::find()->where(['in','field_id',$fid])->orderBy([new \yii\db\Expression('FIELD (status, \'new\',\'success\',\'failed\')'), 'create_at' => SORT_DESC]);
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count,'pageSize'=>10]);
            $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        } else {
            $query = Schedule::find()->where(['user_id'=>$user->id])->orderBy([new \yii\db\Expression('FIELD (status, \'new\',\'success\',\'failed\')'), 'create_at' => SORT_DESC]);
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
            if($sch && $sch->status == 'new'){
                $sch->tracking_code = \Yii::$app->security->generateRandomString(6);
                $sch->status = 'success';
                if($sch->save()){
                    $mess = 'Ma dat san cua ban: '.$sch->tracking_code;
                    $sent = UserController::smsTo($sch->user->phone,$mess);
                    //$sent = 'OK';
                    $ss = Schedule::find()->where(['date'=>$sch->date,'field_id'=>$sch->field_id,'time_range'=>$sch->time_range,'status'=>'new'])->andWhere(['<>','id',$sch->id])->all();
                    foreach($ss as $s){
                        $s->status = 'failed';
                        $s->save();
                    }
                    if($sent == 'OK'){
                        return $sch->tracking_code;
                    } else {
                        return 'send failed';
                    }
                }
            } else {
                return 'false';
            }
        }
    }

    public function actionUpdateNotiCount(){
        if(Yii::$app->request->isAjax){
            if(!Yii::$app->user->isGuest){
                $user = User::findOne(Yii::$app->user->identity->getId());
                if($user->type == 'manager'){
                    $stadiums = Stadiums::findAll(['manager_id'=>$user->id]);
                    $fid = array();
                    foreach ($stadiums as $stadium){
                        $fields = $stadium['fields'];
                        foreach ($fields as $field){
                            $fid[] = $field['id'];
                        }
                    }

                    $count = Schedule::find()->where(['in','field_id',$fid])->andWhere(['status'=>'new'])->count();
                } else {
                    $count = Schedule::find()->where(['user_id'=>$user->id,'status'=>'new'])->count();
                }
                $data[] = $count;
                $data[] = $user->type;
                return json_encode($data);
            } else {
                return false;
            }
        }
    }
}
