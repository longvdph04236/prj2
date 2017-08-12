<?php

namespace frontend\controllers;
use frontend\models\FcList1;
use Yii;
use frontend\models\FilterStadiumForm;
use frontend\models\FcList;
use backend\models\City;
use backend\models\District;
use yii\web\UploadedFile;
use yii\data\Pagination;

class TimDoiController extends \yii\web\Controller
{
    public function actions() {
        $this->view->params['big-title']='Tìm Đối';
        return parent::actions();
    }

    public function actionIndex()
    {
        $model = new FilterStadiumForm();
        $modelForm = new FcList();

        $query = FcList::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize(3);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if(Yii::$app->request->isPost) {
            //ar_dump(Yii::$app->request->post());
            if($modelForm->load(Yii::$app->request->post())) {
                $modelForm->img = UploadedFile::getInstance($modelForm,'img');
                //var_dump($modelForm);die;
                if($modelForm->validate()){

                    if($modelForm->img) {
                        $timemarker = str_replace(' ','_',microtime());
                        $filename = $modelForm->img->basename.$timemarker .'.'.$modelForm->img->extension;
                        if($modelForm->img->saveAs(Yii::$app->params['appPath'].'/uploads/images/'.$filename)){
                            $modelForm->photo = $filename;
                            $modelForm->img = null;
                        }
                    }
                    $d = District::find()->where(['name'=>$modelForm->district_id])->one();
                    $newmodel = new FcList1();
                    $newmodel->district_id = $d->id;
                    $newmodel->fc_name = $modelForm->fc_name;
                    $newmodel->photo = $modelForm->photo;
                    $newmodel->field_type = $modelForm->field_type;
                    $newmodel->kickoff = $modelForm->kickoff;
                    $newmodel->phone = $modelForm->phone;
                    $newmodel->rented = $modelForm->rented;
                    $newmodel->description = $modelForm->description;
                    if($newmodel->save()){
                        Yii::$app->session->setFlash('success','Đăng tin thành công');
                        $modelForm = new FcList();
                    }else {

                        var_dump($newmodel->errors);die;
                    }
                } else {
                    var_dump($modelForm->errors);die;
                }
            }
        }
        return $this->render('index',['model'=>$model,'modelForm'=>$modelForm,'show'=>$articles,'pagination'=>$pagination]);
    }

    public function actionAjaxValidate(){
        $model = new FilterStadiumForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionAjaxValidateFc(){
        $model = new FcList();
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
                $r[] =$v['name'];
            }
            return json_encode($r);
        }
    }



}
