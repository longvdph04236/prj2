<?php

namespace backend\controllers;
use backend\models\District;
use Yii;
use yii\web\Controller;
use backend\models\City;
use yii\data\Pagination;
use yii\helpers\Url;


class CityController extends Controller
{

    public function beforeAction($action)
    {
        if($this->action->id != 'index') {
            $this->view->params['breadcrumbs'][] = ['label' => 'Quản lý khu vực', 'url' => Url::toRoute('city/index')];
        }else {
            $this->view->params['breadcrumbs'][] = ['label' => 'Quản lý khu vực'];
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new City();
        $query = City::find();
        $count = $model->getCount();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize(5);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);
    }

    public function actionCreate() {
        $model = new City();
        if(Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->addFlash('success', 'Thêm khu vực thành công');
                        return $this->redirect(['view','id'=>$model->id]);
                    } else {
                        Yii::$app->session->addFlash('danger', 'Thêm mới không thành công');
                    }
                }
            }
        }
        return $this->render('create', ['model' => $model]);

    }

    public function actionView(){
        return $this->render('view',['model'=>$this->findModel()]);
    }

    public function actionDelete(){
        $request = Yii::$app->request->get();
        $id =$request['id'];
        if($district = District::deleteAll(['city_id'=>$id])) {
            $model = City::findOne($id);
            if ($model->delete()) {
                Yii::$app->session->addFlash('success', 'Xóa khu vực thành công');
                return $this->redirect('index');
            }
        }else {
            $model = City::findOne($id);
            if ($model->delete()) {
                Yii::$app->session->addFlash('success', 'Xóa khu vực thành công');
                return $this->redirect('index');
            }
        }
    }


    public function actionUpdate() {
        $model = $this->findModel();
        if(Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post())) {
                if($model->validate()) {
                    if($model->save()) {
                        Yii::$app->session->addFlash('success','Cập Nhập khu vực thành công');
                        return $this->redirect('index');
                    }else {
                        yii::$app->session->addFlash('danger','Cập nhật không thành công');
                    }
                }
            }
        }
        return $this->render('update',['model'=>$model]);
    }

    public function findModel() {
        $request = yii::$app->request->get();
        $id = $request['id'];
        $model = new City();
        if(($model =$model->getModel($id)) !== null) {
            return $model;
        }else {
            return 'yêu cầu trang không tồn tại';
        }
    }




}
