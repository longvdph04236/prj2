<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 14/08/2017
 * Time: 8:52 SA
 */

namespace frontend\models;


use yii\base\Model;

class FindTrackingCode extends Model
{
    public $code;
    public function rules()
    {
        return [
            ['code','required'],
            ['code','string']
        ];
    }
}