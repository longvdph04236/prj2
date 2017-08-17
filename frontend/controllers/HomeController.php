<?php

namespace frontend\controllers;

use common\models\City;
use common\models\District;
use common\models\Field;
use common\models\Schedule;
use common\models\Stadiums;
use common\models\User;
use frontend\models\FilterStadiumForm;
use frontend\models\FindByNameForm;
use frontend\models\FindByTimeForm;
use frontend\models\FindTrackingCode;
use yii\data\Pagination;
use Yii;


class HomeController extends \yii\web\Controller
{

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $user = User::findOne(Yii::$app->user->identity->getId());
            if($user->status != 'activated'){
                return $this->redirect(['user/kich-hoat','u'=>$user->accessToken]);
            }
        }
        $byTimeModel = new FindByTimeForm();
        $byNameModel = new FindByNameForm();
        $findCode = new FindTrackingCode();
        $this->layout = 'homepage';
        if(Yii::$app->request->isPost){

            if(Yii::$app->request->post('find-time')){
                if($byTimeModel->load(Yii::$app->request->post()) && $byTimeModel->validate()){
                    $district = District::find()->join('inner join','city')->where(['district.name'=>$byTimeModel->district,'city.name'=>$byTimeModel->city])->one();
                    $stadiums = Stadiums::find()->where(['district_id'=>$district['id']])->all();
                    $result = array();
                    $list_std = array();
                    foreach ($stadiums as $stadium){
                        $fields = $stadium['fields'];
                        $tmp = array();
                        foreach ($fields as $field) {
                            $sch = Schedule::find()->where(['field_id'=>$field['id'],'date'=>$byTimeModel->date,'time_range'=>$byTimeModel->time])->one();

                            if(!$sch){
                                $tmp[] = $field['id'];
                            }
                        }
                        if(count($tmp)!= 0){
                            $result[$stadium['id']] = count($tmp);
                            $list_std[] = $stadium['id'];
                        }
                    }
                    $this->view->params['big-title'] = 'Tìm kiếm';
                    $this->layout = 'main';
                    $model = new FilterStadiumForm();
                    $query = Stadiums::find()->where(['in','id',$list_std]);
                    $list_std_str = implode(',',$list_std);
                    $count = $query->count();
                    $pagination = new Pagination(['totalCount'=>$count]);
                    $pagination->setPageSize(5);
                    $articles = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
                    return $this->render('timsan',['result'=>$result,'model'=>$model,'articles'=>$articles,'pagination'=>$pagination,'lid'=>$list_std_str]);
                }
            }

            if(Yii::$app->request->post('find-name')){
                if($byNameModel->load(Yii::$app->request->post()) && $byNameModel->validate()){
                    $this->view->params['big-title'] = 'Tìm kiếm';
                    $this->layout = 'main';
                    $model = new FilterStadiumForm();
                    $w = [];
                    if(!empty($byNameModel->district)){
                        $district = District::find()->where(['name'=>$byNameModel->district])->one();
                        $w['id'] = $district['id'];
                    } else {
                        if(!empty($byNameModel->city)){
                            $city = City::find()->where(['name'=>$byNameModel->city])->one();
                            $districts = $city['districts'];
                            $districts_id = [];
                            foreach ($districts as $d){
                                $districts_id[] = $d['id'];
                            }
                            $w['id'] = $districts_id;
                        }
                    }

                    $query = Stadiums::find()->where($w)->andWhere(['like','name',$byNameModel->name]);
                    $ss = $query->all();
                    $list_std = [];
                    foreach ($ss as $s){
                        $list_std[] = $s['id'];
                    }
                    $list_std_str = implode(',',$list_std);
                    $count = $query->count();
                    $pagination = new Pagination(['totalCount'=>$count]);
                    $pagination->setPageSize(5);
                    $articles = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
                    return $this->render('timsan',['model'=>$model,'articles'=>$articles,'pagination'=>$pagination,'lid'=>$list_std_str]);
                }
            }
            if(Yii::$app->request->post('find-code')){
                if($findCode->load(Yii::$app->request->post()) && $findCode->validate()){
                    $this->view->params['big-title'] = 'Tìm kiếm';
                    $this->layout = 'main';
                    $model = new FilterStadiumForm();

                    $code = Schedule::find()->where(['tracking_code'=>$findCode->code])->one();
                    //var_dump($code);die;
                    return $this->render('timcode',['model'=>$model,'code'=>$code]);
                }
            }

            if(Yii::$app->request->post('filter-option')){
                $filterModel = new FilterStadiumForm();

                if($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()){
                    $this->view->params['big-title'] = 'Tìm kiếm';
                    $this->layout = 'main';
                    $list_std = explode(',',$filterModel->res);
                    $districts_id = [];
                    $type = [];
                    $filter = [];
                    $filter['id'] = $list_std;
                    //var_dump($filter['id']);die;
                    if(!empty($filterModel->district)){
                        $district = District::find()->where(['name'=>$filterModel->district])->one();
                        $filter['district_id'] = $district['id'];
                    } else {
                        if(!empty($filterModel->city)){
                            $city = City::find()->where(['name'=>$filterModel->city])->one();
                            $districts = $city['districts'];
                            foreach ($districts as $d){
                                $districts_id[] = $d['id'];
                            }
                            $filter['district_id'] = $districts_id;
                        }
                    }

                    if(!empty($filterModel->type)){
                        foreach ($filterModel->type as $v){
                            $type[] = $v;
                        }
                        $fields = Field::find()->where(['field_id'=>$list_std,'field_type'=>$type])->all();
                        $tmp = [];
                        foreach ($fields as $f){
                            $tmp[] = $f['field']['id'];
                        }
                        //var_dump($tmp);die;
                        $filter['id'] = array_diff($filter['id'],$tmp);
                    }

                    $query = Stadiums::find()->where($filter);

                    if($filterModel->rating != '0'){
                        //var_dump((float)$filterModel->rating);die;
                        $query->andWhere(['>=','(`rate`/`count_rate`)',(float)$filterModel->rating]);
                    }
                    //var_dump($query->createCommand()->getRawSql());die;
                    $count = $query->count();
                    $pagination = new Pagination(['totalCount'=>$count]);
                    $pagination->setPageSize(5);
                    $articles = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
                    //var_dump($articles);die;
                    return $this->render('timsan',['model'=>$filterModel,'articles'=>$articles,'pagination'=>$pagination,'lid'=>$filterModel->res]);
                }
            }
        }
        return $this->render('index',['TimeModel'=>$byTimeModel,'NameModel' => $byNameModel,'FindCode'=>$findCode]);
    }

    public function actionAjaxValidateBt(){
        $model = new FindByTimeForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
    public function actionAjaxValidateBn(){
        $model = new FindByNameForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
    }

    public function actionAjaxValidate(){
        $model = new FilterStadiumForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
}
