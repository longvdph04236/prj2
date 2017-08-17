<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 16/08/2017
 * Time: 12:16 CH
 */

namespace frontend\models;

use common\models\City;
use common\models\District;
use yii\base\Model;

class FilterFcForm extends Model
{
    public $date;
    public $time;
    public $city;
    public $district;
    public $type;

    public function rules()
    {
        return [
            [['date','time'], 'string'],
            ['type','safe'],
            ['city', 'exist', 'targetClass'=>'\common\models\City', 'targetAttribute' => 'name','message'=>'Tỉnh/thành phố không tồn tại'],
            ['district', 'validateDistrict']
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