<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 14/08/2017
 * Time: 8:21 SA
 */

namespace frontend\models;


use yii\base\Model;
use common\models\District;
use common\models\City;

class FindByTimeForm extends Model
{
    public $date;
    public $time;
    public $city;
    public $district;
    public function rules()
    {
        return[
            [['date','time','city','district'], 'required'],
            ['date', 'safe'],
            ['time','string'],
            ['city', 'exist', 'targetClass'=>'\common\models\City', 'targetAttribute' => 'name','message'=>'Tỉnh/thành phố không tồn tại'],
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
}