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


class FilterStadiumForm extends Model
{
    public $name;
    public $city;
    public $dis;
    public $type;
    public $price;
    public $rating;

    public function rules()
    {
        return [
            ['price','min'=>0],
        ];
    }

    public function attributeLabels()
    {
       return [
           'name'=>'Tên Sân',
           'city'=>'Thành Phố',
           'dis'=>'Quận/Huyện',
           'price'=>'Khung Giá',
           'type'=>'Loại Sân',
           'rating'=>'Đánh Giá'
       ];
    }

    public function getCity() {
        $c = City::find();
    }

}