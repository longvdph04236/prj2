<?php

namespace frontend\controllers;
use Yii;
use common\models\Field;
use common\models\Pricing;
use common\models\Schedule;
use common\models\Stadiums;
use common\models\Comments;
use yii\base\Model;
use yii\widgets\NameToLink;

class SanBongController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $this->layout = 'sanbong';
        $stadium = Stadiums::findOne($id);

        $p = explode('/',ltrim($_SERVER["REQUEST_URI"],'/'))[3];
        if(count(explode('-',$p)) ==1){
            $arr = array_merge([$id],explode(' ',$stadium['name']));
            NameToLink::$name = implode('-',$arr);
            $link = NameToLink::run();
            return $this->redirect(['san-bong/chi-tiet/'.$link]);
        }

        $this->view->params['big-title'] = $stadium['name'];
        $this->view->params['location'] = $stadium['address'];
        $info['district'] = $stadium->district->name;
        $info['city'] = $stadium->district->city->name;
        $info['stadium'] = $stadium;
        $this->view->params['id-san'] = $stadium->id;
        $FieldModel = new Field();
        $PriceModel = new Pricing();
        $ScheduleModel = new Schedule();
        $CmtModel = new Comments();
        if(Yii::$app->request->isPost){
            if(Yii::$app->request->post('add-field-submit')){
                if($FieldModel->load(Yii::$app->request->post())){
                    if($FieldModel->validate() && $FieldModel->save()){
                        Yii::$app->session->setFlash('s','Đã thêm sân bóng');
                    }else{
                        var_dump($FieldModel->errors);
                        die;
                    }
                } else {
                    die('cannot load');
                }
            }
            if(Yii::$app->request->post('add-comment')){
                if($CmtModel->load(Yii::$app->request->post())){
                    if($CmtModel->validate() && $CmtModel->save()){
                        Yii::$app->session->setFlash('s','Đã thêm bình luận');
                        if(isset($CmtModel->rate)){
                            $stadium->rate += $CmtModel->rate;
                            $stadium->count_rate++;
                            $CmtModel = new Comments();
                            if(!$stadium->save()){
                                var_dump($stadium->errors);die;
                            }
                        }
                    }else{
                        var_dump($CmtModel->errors);
                        die;
                    }
                } else {
                    die('cannot load');
                }
            }
            if(Yii::$app->request->post('pricing-update')){
                $pricing = Pricing::find()->where(['field_type'=>Yii::$app->request->post('Pricing')['field_type']])->andWhere(['field_id'=>Yii::$app->request->post('Pricing')['field_id']])->all();
                if(count($pricing) == 10){
                    Model::loadMultiple($pricing,Yii::$app->request->post());
                } else {
                    $temp = array_slice(Yii::$app->request->post('Pricing'),0,10);

                    $new_arr = array_diff_key($temp,$pricing);

                    if(count($new_arr) != 0){
                        foreach ($new_arr as $n) {
                            unset($n['id']);
                            $new_pricing_model = new Pricing();
                            foreach ($n as $k => $v) {

                                $new_pricing_model->{$k} = $v;
                            }
                            if($new_pricing_model->validate()){
                                $new_pricing_model->save();
                                Yii::$app->session->setFlash('s','Giá sân đã được cập nhật');
                                return $this->redirect(['san-bong/chi-tiet/'.$id]);
                            }
                        }
                    }
                }
                if(Model::validateMultiple($pricing)){
                    //var_dump($pricing);die;
                    foreach ($pricing as $p) {
                        $p->save(false);
                        Yii::$app->session->setFlash('s','Giá sân đã được cập nhật');
                        return $this->redirect(['san-bong/chi-tiet/'.$id]);
                    }
                } else {
                    foreach ($pricing as $p) {
                        var_dump($p->errors);
                    }
                    die;
                }
            }
            if(Yii::$app->request->post('book-field')){
                if($ScheduleModel->load(Yii::$app->request->post()) && $ScheduleModel->validate()){
                    if(!isset($ScheduleModel->field_id)){
                        $fields = Field::find()->where(['field_type'=>$ScheduleModel->field_type,'field_id'=>$stadium->id])->all();
                        $ft = array();
                        foreach ($fields as $field){
                            $ft[] = $field['id'];
                        }

                        $booked_fields = Schedule::find()->where(['field_type'=>$ScheduleModel->field_type,'date'=>$ScheduleModel->date,'time_range'=>$ScheduleModel->time_range,'status'=>'success'])->all();
                        $bfid = array();
                        foreach ($booked_fields as $booked_field){
                            $bfid[] = $booked_field['field_id'];
                        }
                        $empty_field = array_diff($ft,$bfid);
                        if(count($empty_field)==0){
                            $ScheduleModel->addError('date','Không còn sân trống vào thời gian này');
                            $ScheduleModel->addError('date','Không còn sân trống vào thời gian này');
                        } else {
                            $ScheduleModel->field_id = $empty_field[0];
                        }
                    }
                    if($ScheduleModel->user->id == $stadium->manager->id){
                        $ScheduleModel->status = 'success';
                        $ScheduleModel->tracking_code = Yii::$app->security->generateRandomString(6);
                    }
                    $ScheduleModel->create_at = date('Y-m-d H:i:s',time());
                    if($ScheduleModel->save()){
                        Yii::$app->session->setFlash('s','Đã gửi thông báo cho quản lý của sân!');
                    } else {
                        var_dump($ScheduleModel->errors);
                        die;
                    }
                } else {
                    var_dump($ScheduleModel->errors);
                    die;
                }
            }
        }
        return $this->render('index', ['info'=>$info,'fModel'=>$FieldModel, 'pModel'=>$PriceModel, 'sModel'=>$ScheduleModel, 'cModel'=>$CmtModel]);
    }

    public function actionXoa(){
        $id = Yii::$app->request->get('id');
        $s = Yii::$app->request->get('s');
        $field = Field::findOne($id);
        if(!$field->delete()){
            Yii::$app->session->setFlash('f','Xóa sân không thành công');
        } else {
            Pricing::deleteAll(['field_id'=>$s,'field_type'=>$field['field_type']]);
            Yii::$app->session->setFlash('s','Xóa sân thành công');
        }
        return $this->redirect(['san-bong/chi-tiet/'.$s]);
    }
}
