<?php
namespace backend\models;

use yii;
use yii\base\Model;
use common\models\Admin;
use yii\captcha\Captcha;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $id;
    public $username;
    public $email;
    public $password;
	public $rePassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Admin', 
			'message' => Yii::t('common','This username has already been taken.')],
			
            ['username', 'string', 'min' => 3, 'max' => 16],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Admin', 
			'message' => Yii::t('common','This email address has already been taken.')],

            [['password','rePassword'], 'required'],
            [['password','rePassword'], 'string', 'min' => 6],
			['rePassword','compare','compareAttribute'=>'password',
			'message'=>Yii::t('common','Two times the password inconsistent')],
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
        
        $user = new Admin();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = time();
        $user->updated_at = time();
        
        return $user->save() ? $user : null;
    }
	
	public function attributeLabels(){
		return[
			'username'=>Yii::t('common','Username'),
			'email'=>Yii::t('common','Email'),
			'password'=>Yii::t('common','Password'),
			'rePassword'=>Yii::t('common','rePassword'),
		];
	}
}
