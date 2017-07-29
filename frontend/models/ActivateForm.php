<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 27/07/2017
 * Time: 12:01 CH
 */

namespace frontend\models;
use Yii;
use yii\base\Model;

class ActivateForm extends Model
{
    public $otp;
    public $aT;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->aT = Yii::$app->request->getQueryParam('u');
    }

    public function rules()
    {
        return [
            ['otp', 'required', 'Mã kích hoạt bắt buộc'],
            ['otp', 'string', 'length' => 4]
        ];
    }
}