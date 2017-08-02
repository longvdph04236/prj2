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
            ['newPass', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Mật khẩu không khớp'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPass', 'message' => 'Mật khẩu không khớp'],
        ];
    }

    public function update($id){
        if($this->validate()){
            $user = User::findOne($id);
            if(\Yii::$app->security->validatePassword($this->password,$user->password)){
                $user->password = \Yii::$app->security->generatePasswordHash($this->newPass);
                if($user->save()){
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            var_dump($this->errors);die;
        }
    }
}