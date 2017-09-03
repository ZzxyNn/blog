<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
// use yii\web\Controller; 用自定义基础控制器替换
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\controllers\base\BaseController;
use yii\base\Object;
use frontend\models\FeedForm;

/**
 * Site controller
 */
class SiteController extends BaseController {
	public $enableCsrfValidation = false;
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [ 
				'access' => [ 
						'class' => AccessControl::className (),
						'only' => [ 
								'logout',
								'signup',
								'addfeed' 
						],
						'rules' => [ 
								[ 
										'actions' => [ 
												'signup' 
										],
										'allow' => true,
										'roles' => [ 
												'?' 
										] 
								],
								[ 
										'actions' => [ 
												'logout',
												'addfeed' 
										],
										'allow' => true,
										'roles' => [ 
												'@' 
										] 
								] 
						] 
				],
				'verbs' => [ 
						'class' => VerbFilter::className (),
						'actions' => [ 
								'logout' => [ 
										'get',
										'post' 
								],
								'addfeed' => [ 
										'get',
										'post' 
								] 
						] 
				] 
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
						'maxLength' => 4, // 最大显示个数
						'minLength' => 4, // 最少显示个数
						'padding' => 2 
				] // 间距
,
				// 图片上传
				'upload' => [ 
						'class' => 'common\widgets\file_upload\UploadAction', // 这里扩展地址别写错
						'config' => [ 
								'imagePathFormat' => "/images/{yyyy}{mm}{dd}/{time}{rand:6}" 
						] 
				] 
		];
	}
	
	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		return $this->render ( 'index' );
	}
	
	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin() {
		if (! Yii::$app->user->isGuest) {
			return $this->goHome ();
		}
		
		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		} else {
			return $this->render ( 'login', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout() {
		Yii::$app->user->logout ();
		
		return $this->goHome ();
	}
	
	/**
	 * Displays contact page.
	 *
	 * @return mixed
	 */
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			if ($model->sendEmail ( Yii::$app->params ['adminEmail'] )) {
				Yii::$app->session->setFlash ( 'success', 'Thank you for contacting us. We will respond to you as soon as possible.' );
			} else {
				Yii::$app->session->setFlash ( 'error', 'There was an error sending your message.' );
			}
			
			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [ 
					'model' => $model 
			] );
		}
	}
	
	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout() {
		return $this->render ( 'about' );
	}
	
	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup() {
		$model = new SignupForm ();
		if ($model->load ( Yii::$app->request->post () )) {
			if ($user = $model->signup ()) {
				if (Yii::$app->getUser ()->login ( $user )) {
					return $this->goHome ();
				}
			}
		}
		
		return $this->render ( 'signup', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionRequestPasswordReset() {
		$model = new PasswordResetRequestForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->validate ()) {
			if ($model->sendEmail ()) {
				Yii::$app->session->setFlash ( 'success', 'Check your email for further instructions.' );
				
				return $this->goHome ();
			} else {
				Yii::$app->session->setFlash ( 'error', 'Sorry, we are unable to reset password for the provided email address.' );
			}
		}
		
		return $this->render ( 'requestPasswordResetToken', [ 
				'model' => $model 
		] );
	}
	
	/**
	 * Resets password.
	 *
	 * @param string $token        	
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token) {
		try {
			$model = new ResetPasswordForm ( $token );
		} catch ( InvalidParamException $e ) {
			throw new BadRequestHttpException ( $e->getMessage () );
		}
		
		if ($model->load ( Yii::$app->request->post () ) && $model->validate () && $model->resetPassword ()) {
			Yii::$app->session->setFlash ( 'success', 'New password saved.' );
			
			return $this->goHome ();
		}
		
		return $this->render ( 'resetPassword', [ 
				'model' => $model 
		] );
	}
	public function actionAddFeed() {
		$model = new FeedForm ();
		
		if (! isset ( Yii::$app->user->identity )) {
			return json_encode ( [ 
					'status' => false,
					'msg' => '请先登录！' 
			] );
		}
		
		$model->content = Yii::$app->request->post ( 'content' );
		
		if ($model->validate ()) {
			if ($model->create ()) {
				return json_encode ( [ 
						'status' => true 
				] );
			}
		}
		
		return json_encode ( [ 
				'status' => false,
				'msg' => '发布失败！' 
		] );
		
		// $model->content = Yii::$app->request->post('content');
		
		// if($model->validate()){
		// if($model->created()){
		// return json_encode(['status'=>true]);
		// }
		// }
		// return json_decode(['status'=>false,'msg'=>'失败']);
	}
}