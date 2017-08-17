<?php

namespace frontend\controllers;
use common\models\District;
use common\models\User;
use frontend\models\NewStadiumForm;
use Yii;
use common\models\Field;
use common\models\Pricing;
use common\models\Schedule;
use common\models\Stadiums;
use common\models\Comments;
use yii\base\Model;
use yii\widgets\NameToLink;
use yii\web\UploadedFile;

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
                        $new_model_array = array();
                        foreach ($new_arr as $n) {
                            unset($n['id']);
                            $new_pricing_model = new Pricing();
                            foreach ($n as $k => $v) {
                                $new_pricing_model->{$k} = $v;
                            }
                            if($new_pricing_model->validate()){
                                $new_model_array[] = $new_pricing_model;
                            } else {
                                Yii::$app->session->setFlash('s','Giá nhập không hợp lệ');
                                return $this->redirect(['san-bong/chi-tiet/'.$id]);
                            }
                        }
                        foreach ($new_model_array as $new_model){
                            $new_model->save();
                        }
                        Yii::$app->session->setFlash('s','Giá sân đã được cập nhật');
                        return $this->redirect(['san-bong/chi-tiet/'.$id]);
                    }
                }
                if(Model::validateMultiple($pricing)){
                    //var_dump($pricing);die;
                    foreach ($pricing as $p) {
                        $p->save(false);
                    }
                    Yii::$app->session->setFlash('s','Giá sân đã được cập nhật');
                    return $this->redirect(['san-bong/chi-tiet/'.$id]);
                } else {
                    foreach ($pricing as $p) {
                        var_dump($p->errors);
                    }
                    die;
                }
            }
            if(Yii::$app->request->post('book-field')){
                if($ScheduleModel->load(Yii::$app->request->post()) && $ScheduleModel->validate()){

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
                        Yii::$app->session->setFlash('f','Không còn sân trống ở khung giờ '.$ScheduleModel->time_range.' ngày '.$ScheduleModel->date );
                        return $this->redirect(['san-bong/chi-tiet/'.$id]);
                    } else if(empty($ScheduleModel->field_id)){
                            $ScheduleModel->field_id = $empty_field[array_rand($empty_field)];
                    }
                    if($ScheduleModel->user->id == $stadium->manager->id){
                        $ScheduleModel->status = 'success';
                        $ScheduleModel->tracking_code = Yii::$app->security->generateRandomString(6);
                    }
                    //$ScheduleModel->create_at = date('Y-m-d H:i:s',time());
                    //var_dump($ScheduleModel);die;
                    if($ScheduleModel->save()){
                        if($ScheduleModel->user->id != $stadium->manager->id) {
                            Yii::$app->session->setFlash('s', 'Đã gửi thông báo cho quản lý của sân!');
                        }
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

    public function actionXoaLich($id){
        $user = User::findOne(Yii::$app->user->identity->getId());
        $sch = Schedule::findOne($id);

        if($user->type == 'manager'){
            $field = $sch->field;
            $stadium = $field->field;
            $owner = $stadium->manager;
            if($user->id == $owner->id){
                if($sch->delete()){
                    Yii::$app->session->setFlash('s','Đã xóa thành công lịch thi đấu');
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    var_dump($sch->errors);die;
                }
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else if($user->type == 'member') {
            if($sch->user_id == $user->id){
                if($sch->delete()){
                    Yii::$app->session->setFlash('s','Đã hủy thành công yêu cầu đặt sân');
                    return $this->redirect(Yii::$app->request->referrer);
                } else {
                    var_dump($sch->errors);die;
                }
            } else {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionUpdateLich(){
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            /*$post['id'] = 1;
            $post['rendered'] = [1];*/
            $field = Field::findOne($post['id']);
            //var_dump($post);
            if(!empty($post['rendered'])){
                $sch = Schedule::find()->where(['field_id'=>$field->id,'status'=>'success'])->andWhere(['not', ['tracking_code' => null]])->andWhere(['not in','id',$post['rendered']])->select(['id','tracking_code','date','time_range','name','user_id'])->orderBy(['last_modified' => SORT_DESC])->all();
                //echo '1';
            } else {
                $sch = Schedule::find()->where(['field_id'=>$field->id,'status'=>'success'])->andWhere(['not', ['tracking_code' => null]])->select(['id','tracking_code','date','time_range','name','user_id'])->orderBy(['last_modified' => SORT_DESC])->all();
                //echo '2';
            }

            $user = User::findOne(Yii::$app->user->identity->getId());
            $data = array();
            foreach($sch as $s){
                $u = User::findOne($s['user_id']);
                //var_dump($u);die;
                if(empty($s['name'])){
                    $s->setAttribute('name',$u->fullname);
                }
                $data[] = $s->getAttributes();
            }
            $datas[]=$user->type;
            $datas[]=$data;
            /*echo '<pre>';
            var_dump($data);die;
            echo '</pre>';*/
            return json_encode($datas);
        }
    }

    public function actionSua($id){
        $model =  new NewStadiumForm();
        $stadium = Stadiums::findOne($id);
        $model->name = $stadium->name;
        $model->address = $stadium->address;
        $model->description = $stadium->description;
        $model->city = $stadium->district->city->name;
        $model->district = $stadium->district->name;
        $model->phone = $stadium->phone;
        $model->google = $stadium->google_map;
        $model->photos = $stadium->photos;
        //var_dump($model->photos);die;
        if($model->photos != NULL){
            $photos = explode(',',$model->photos);
            $photos = array_filter($photos);
            $model->oldImg = $photos;
        } else {
            $model->oldImg = array();
        }
        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->photos = UploadedFile::getInstances($model, 'photos');
                //var_dump($_FILES);die;
                if($model->upload($id)){
                    return $this->redirect(['quan-ly-san/index']);
                }
            }
        }
        $this->view->params['big-title'] = 'Cập nhật thông tin sân bóng';
        return $this->render('sua',['model' => $model, 'stadium'=>$stadium]);
    }

    public function actionUpdateLich2(){
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            /*$post['id'] = 1;
            $post['rendered'] = [1];*/
            $field = Field::findOne($post['id']);
            //var_dump($post['rendered']);
            $sch = Schedule::find()->where(['field_id'=>$field->id,'status'=>'success'])->select(['id','tracking_code','date','time_range','name','user_id'])->orderBy(['last_modified' => SORT_DESC])->all();
            $data = array();
            if(!empty($post['rendered'])){
                $newArr = array();
                foreach($sch as $s){
                    $newArr[] = $s['id'];
                }
                $data = array_diff($post['rendered'],$newArr);
            }
            $datas = array();
            $datas[] = $data;
            $datas[] = Yii::$app->user->isGuest;

            return json_encode($datas);
        }
    }
}