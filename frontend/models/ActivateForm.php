<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 27/07/2017
 * Time: 12:01 CH
 */

namespace frontend\models;

use yii\base\Model;

class ActivateForm extends Model
{
    public $otp;
    public function rules()
    {
        return [
            ['otp', 'required', 'Mã kích hoạt bắt buộc'],
            ['otp', 'string', 'length' => 4]
        ];
    }
}