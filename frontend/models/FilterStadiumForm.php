<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/8/2017
 * Time: 0:03 AM
 */

namespace frontend\models;
use yii\base\Model;
use common\models\District;
Use backend\models\City;
Use common\models\Stadiums;
use frontend\models\Field;


class FilterStadiumForm extends Model
{
    public $name;
    public $city;
    public $district;
    public $type;
    public $price;
    public $rating;

    public function rules()
    {
        return [
            ['city', 'exist', 'targetClass'=>'\backend\models\City', 'targetAttribute' => 'name','message'=>'Tỉnh/thành phố không tồn tại'],
            ['district', 'validateDistrict']
        ];
    }

    public function attributeLabels()
    {
       return [
           'name'=>'Tên Sân:',
           'city'=>'Thành Phố:',
           'district'=>'Quận/Huyện:',
           'price'=>'Khung Giá:',
           'type'=>'Loại Sân:',
           'rating'=>'Đánh Giá:'
       ];
    }

    public function validateDistrict($attribute, $params, $validator){
        if($this->city == '') {
            $this->addError($attribute, 'Bạn chưa chọn tỉnh thành phố');
        }
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




}