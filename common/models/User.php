<?php
/**
 * Created by PhpStorm.
 * User: Jessie Sam
 * Date: 24/07/2017
 * Time: 4:41 CH
 */

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 'inactive';
    const STATUS_ACTIVE = 'activated';
    public $newPhoto;

    public static function tableName()
    {
        return 'users';
    }


    public function rules()
    {
        return [
            [['newPhoto'], 'file', 'extensions' => 'jpg, png'],
            [['fullname', 'username', 'password', 'phone', 'type'], 'required'],
            [['type', 'status'], 'string'],
            [['fullname'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 30],
            [['password', 'email', 'avatar', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],

            ['username', 'trim'],
            ['username', 'required', 'message' => 'Tên đăng nhập bắt buộc'],
            ['username', 'unique', 'targetClass' => '\common\models\Users', 'filter' => ['<>','id', $this->id],'message' => 'Tên đăng nhập đã tồn tại'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email','message' => 'Email không hợp lệ'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'filter' => ['<>','id', $this->id], 'message' => 'Email đã tồn tại'],

            ['fullname', 'string', 'min' => 10, 'max' => 60, 'message' => 'Họ và tên phải có ít nhất 10 ký tự, nhiều nhất 60 ký tự'],
            ['fullname', 'required', 'message' => 'Họ tên đầy đủ bắt buộc'],

            ['phone', 'required', 'message' => 'Số điện thoại bắt buộc'],
            ['phone', 'match', 'pattern' => '/^((0|\+84|84)1[2689]|(0|\+84|84)9)[0-9]{8}$/', 'message' => 'Số điện thoại không hợp lệ'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'type' => 'Type',
            'avatar' => 'Avatar',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'status' => 'Status',
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

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findAdmin()
    {
        return static::findOne(['type' => 'admin', 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }



    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getStatus(){
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }


    /**
     * Generates new password reset token
     *
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     *
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * @inheritdoc
     */
}