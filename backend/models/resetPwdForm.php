<?php
namespace backend\models;

use yii;
use yii\base\Model;
use common\models\Admin;
use yii\captcha\Captcha;

/**
 * Signup form
 */
class resetPwdForm extends Model
{
    public $password;
	public $rePassword;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','rePassword'], 'required'],
            [['password','rePassword'], 'string', 'min' => 6],
			['rePassword','compare','compareAttribute'=>'password',
			'message'=>Yii::t('common','Two times the password inconsistent')],
        ];
    }

    public function resetPwd($id){
    	if(!$this->validate()){
    		return false;
    	}
    	
    	$admin = Admin::findOne($id);
    	$admin->setPassword($this->password);
    	$admin->removePasswordResetToken();
    	
    	return $admin->save()? true : false;
    }
}
