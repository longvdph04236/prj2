<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use Yii;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirmPassword;
    public $type;
    public $fullName;
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Tên đăng nhập bắt buộc'],
            ['username', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Tên đăng nhập đã tồn tại'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Email đã tồn tại'],

            ['password', 'required','message' => 'Mật khẩu nhập bắt buộc'],
            ['password', 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute' => 'confirmPassword', 'message' => 'Mật khẩu không khớp'],

            ['confirmPassword', 'required', 'message' => 'Xác nhận mật khẩu bắt buộc'],
            ['confirmPassword', 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Mật khẩu không khớp'],

            ['type', 'required', 'message' => 'Hãy chọn loại tài khoản'],

            ['fullName', 'string', 'min' => 10, 'max' => 60],
            ['fullName', 'required', 'message' => 'Họ tên đầy đủ bắt buộc'],

            ['phone', 'required', 'message' => 'Số điện thoại bắt buộc'],
            ['phone', 'match', 'pattern' => '/^((0|\+84)1[2689]|(0|\+84)9)[0-9]{8}$/'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->fullname = $this->fullName;
        $user->phone = (substr($this->phone,0,1) == '0')? substr_replace($this->phone,'84',0,1):ltrim($this->phone,'+');
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->type = $this->type;
        $user->accessToken = Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomKey());
        return $user->save() ? $user : null;
    }
}
