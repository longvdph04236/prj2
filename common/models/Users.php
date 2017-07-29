<?php

namespace common\models;

use yii\db\ActiveRecord;

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
class Users extends ActiveRecord
{

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

}
