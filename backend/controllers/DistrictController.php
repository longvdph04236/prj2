<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/8/2017
 * Time: 13:50 PM
 */

namespace backend\controllers;
use yii\web\Controller;
use yii;
use yii\data\Pagination;
use backend\models\District;


class DistrictController extends Controller
{
    public function beforeAction($action)
    {
        if($this->action->id != 'index') {
            $this->view->params['breadcrumbs'][] = ['label'=>'Quản lý quận Huyện','url'=>['district/index']];
        }else {
            $this->view->params['breadcrumbs'][] = ['label'=>'Quản lý quận huyện'];
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new District();
        $query = District::find();
        $count = $model->getCount();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize(5);
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['model'=>$articles,'pagination'=>$pagination]);
    }

    public function actionCreate() {
        $model = new District();
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
        $model = District::findOne($id);
        if($model->delete()) {
            Yii::$app->session->addFlash('success', 'Xóa khu vực thành công');
            return $this->redirect('index');
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
        $request = Yii::$app->request->get();
        $id = $request['id'];
        if(isset($id)) {
            $model = District::findOne($id);
            return $model;
        }else {
            return 'yêu cầu trang không tồn tại';
        }
    }
}