<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 03/08/2017
 * Time: 2:20 CH
 */

namespace frontend\models;

use backend\models\City;
use backend\models\District;
use common\models\Stadiums;
use yii\base\Model;
use Yii;

class NewStadiumForm extends Model
{
    public $oldImg;
    public $photos;
    public $name;
    public $address;
    public $description;
    public $city;
    public $district;
    public $phone;
    public $google;

    public function rules()
    {
        return [
            [['name','city','district','address','phone','description','google'],'required', 'message'=>'Thông tin bắt buộc'],
            [['name','address'],'string','max'=>255],
            ['description', 'string'],
            ['google', 'string','max'=>100],
            ['photos', 'file', 'extensions' => 'jpg, png','maxFiles' => 0],
            ['phone', 'required', 'message' => 'Số điện thoại bắt buộc'],
            ['phone', 'match', 'pattern' => '/^((0|\+84)1[2689]|(0|\+84)9)[0-9]{8}$/'],
            ['city', 'exist', 'targetClass'=>'\backend\models\City', 'targetAttribute' => 'name','message'=>'Tỉnh/thành phố không tồn tại'],
            ['district', 'validateDistrict']
        ];
    }

    public function validateDistrict($attribute, $params, $validator){
        $cs = City::find()->where(['name'=>$this->city])->select('id')->all();
        $l = array();
        foreach ($cs as $c){
            $l[] = $c->getAttribute('id');
        }
        $d = District::find()->where(['name'=>$this->district])->andWhere(['in','city_id',$l])->all();
        if(count($d)==0){
            $this->addError($attribute, 'Quận/huyện không tồn tại');
        }
    }

    public function upload($id = null){
        $arr = array();

        if(Yii::$app->controller->action->id == 'sua'){
            //var_dump(Yii::$app->request->post('oldImg'));die;
            if(count(array_diff(Yii::$app->request->post('oldImg'),$this->oldImg)) == 0){
                //count($this->oldimg); die;
                if($this->validate()) {
                    return true;
                }
            } else {
                $arr = array_intersect(Yii::$app->request->post('oldImg'),$this->oldImg);
                //var_dump($arr); die;
            }
        }

        if ($this->validate()) {
            //var_dump($this->photos);die;
            foreach ($this->photos as $file) {
                $timeMarker = str_replace(" ", "_", microtime());
                $filename = $file->baseName . $timeMarker .'.'. $file->extension;
                $arr[] = $filename;

                $file->saveAs(\Yii::getAlias('@common').'/uploads/images/'.$filename);
            }

            if($id != null){
                $s = Stadiums::findOne($id);
            } else {
                $s = new Stadiums();
            }
            $s->photos = implode(',',$arr);
            $s->name = $this->name;
            $s->address = $this->address;
            $s->phone = $this->phone;
            $s->description = $this->description;
            $s->google_map = $this->google;
            $c = City::find()->where(['name'=>$this->city])->one();
            $d = District::find()->where(['name'=>$this->district,'city_id'=>$c->getAttribute('id')])->one();
            $s->district_id = $d->getAttribute('id');
            $s->manager_id = \Yii::$app->user->identity->getId();
            $this->photos = NULL;

            if($s->save()){
                return true;
            } else {
                var_dump($s->errors);
                die('cannot save to db');
            }
        } else {
            return false;
        }
    }
}