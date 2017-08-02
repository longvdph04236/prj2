<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 02/08/2017
 * Time: 1:00 CH
 */

namespace frontend\models;


use common\models\User;
use yii\base\Model;

class UserProfileForm extends Model
{
    public $password;
    public $newPass;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['password','newPass','confirmPassword'], 'required', 'message'=>'Bắt buộc'],
            [['password','newPass','confirmPassword'], 'string', 'min' => 6,'message'=>'Mật khẩu có ít nhất 6 ký tự'],
            ['password', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Mật khẩu không khớp'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Mật khẩu không khớp'],
        ];
    }

    public function update($id){
        if($this->validate()){
            $user = User::findOne($id);
            $user->username = $this->username;
            $user->fullname = $this->fullName;
            $user->email = $this->email;

        }
    }
}