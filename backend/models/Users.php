<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $type
 * @property string $avatar
 * @property string $authKey
 * @property string $accessToken
 * @property string $status
 *
 * @property Comments[] $comments
 * @property Schedule[] $schedules
 * @property Stadiums[] $stadiums
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'username', 'password', 'phone', 'type'], 'required'],
            [['type', 'status'], 'string'],
            [['fullname'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 30],
            [['password', 'email', 'avatar', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Họ Tên',
            'username' => 'Tài Khoản',
            'password' => 'Mật Khẩu',
            'email' => 'Email',
            'phone' => 'Điện Thoại',
            'type' => 'Vai Trò',
            'avatar' => 'Ảnh đại diện',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'status' => 'Trạng thái',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStadiums()
    {
        return $this->hasMany(Stadiums::className(), ['manager_id' => 'id']);
    }

    public function getCount() {
        $data = Users::find();
        return $data;
    }

    public function getModel($id) {
        $data = Users::find(['id'=>$id])->one();
        return $data;
    }
}
