<?php

namespace frontend\controllers;
use backend\models\City;
use Yii;
use backend\models\District;
use frontend\models\NewStadiumForm;
use yii\web\UploadedFile;

class QuanLySanController extends \yii\web\Controller
{
    public function actions()
    {
        $this->view->params['big-title'] = "Quản lý sân bóng";
        return parent::actions(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionThemMoi(){
        $model = new NewStadiumForm();
        $d = District::find()->all();
        if(!Yii::$app->request->isAjax && Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post())){
                $model->photos = UploadedFile::getInstances($model, 'photos');
                if($model->upload()){
                    return $this->redirect(['quan-ly-san/index']);
                }
            }
        }
        return $this->render('add',['model' => $model, 'd' => $d]);
    }

    public function actionAjaxValidate(){
        $model = new NewStadiumForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionGetDistrict(){
        if(Yii::$app->request->isAjax){
            $n = Yii::$app->request->post('n');
            //$n = 'Hà nội';
            $c = City::find()->where(['name'=>$n])->select('id')->one();
            if(count($c) == 0){
                return json_encode(false);
            }
            $d = District::find()->where(['city_id'=>$c->getAttribute('id')])->select('name')->all();
            //var_dump($d);die;
            $r = array();
            foreach ($d as $v){
                $r[] = $v['name'];
            }
            return json_encode($r);
        }
    }
}