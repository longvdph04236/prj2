<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 03/08/2017
 * Time: 2:20 CH
 */

namespace frontend\models;

use yii\base\Model;

class NewStadiumForm extends Model
{
    public $name;
    public $city;
    public $district;
    public $address;
    public $phone;
    public $description;
    public $google;
    public $photos;
    public function rules()
    {
        return [
            [['name','city','district','address','phone','description','google'],'required', 'message'=>'Thông tin bắt buộc'],
            [['name','address'],'string','max'=>255],
            ['description', 'string'],
            ['description', 'string','max'=>30],
            ['photos', 'file', 'extensions' => 'jpg, png'],
            ['phone', 'required', 'message' => 'Số điện thoại bắt buộc'],
            ['phone', 'match', 'pattern' => '/^((0|\+84)1[2689]|(0|\+84)9)[0-9]{8}$/'],
        ];
    }
}