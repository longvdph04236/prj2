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
            ['phone', 'match', 'pattern' => '/^((0|\+84)1[2689]|(0|\+84)9)[0-9]{8}$/','message'=>'Dữ liệu không hợp lệ'],
            ['phone', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Không có người nào có số điện thoại này'
            ],
        ];
    }

}