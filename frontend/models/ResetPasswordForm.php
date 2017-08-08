<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 30/7/2017
 * Time: 20:27 PM
 */

    namespace frontend\models;
    use common\models\User;
    use yii\base\Model;


class ResetPasswordForm extends Model
{
    public $phone;

    public function rules()
    {
        return [
            ['phone', 'required', 'message' => 'Số điện thoại bắt buộc'],
            ['phone', 'match', 'pattern' => '/^((0|\+84|84)1[2689]|(0|\+84|84)9)[0-9]{8}$/','message'=>'Dữ liệu không hợp lệ'],
            ['phone','checkPhone']

        ];
    }
    public function checkPhone() {
        if (substr($this->phone,0,1) == '0') {
            $this->phone = substr_replace($this->phone,'84',0,1);

        }else if(substr($this->phone,0,1) == '+') {
            $this->phone = ltrim($this->phone,'+');
        }

        if (User::find()->where(['phone'=>$this->phone])->count()== 0 )  {
            $this->addError('phone','Số điện thoại không tồn tại');
        }
    }


}