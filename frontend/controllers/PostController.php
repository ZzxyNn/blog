<?php

namespace frontend\controllers;

use yii;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use common\models\CatModel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Object;
use common\models\PostExtends;
use yii\web\ForbiddenHttpException;

/**
* 文章控制器
*/
class PostController extends BaseController{
	
	/**
	 * 行为过滤器（对控制器里的方法进行过滤）
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
				'access' => [
						'class' => AccessControl::className(),
						//only 选项指明 ACF 应当只 对 index， create ，upload和 ueditor 方法起作用
						'only' => ['index','create','upload','ueditor'],
						'rules' => [
								[
										'actions' => ['index'],
										'allow' => true,
								],
								[
										'actions' => ['create','upload','ueditor'],
										'allow' => true,
										'roles' => ['@'],//‘@’代表已认证用户
								],
						],
				],
				//指定该规则用于匹配哪种请求方法（例如GET，POST）。 这里的匹配大小写不敏感
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								'create' => ['get', 'post'],
						],
				],
		];
	}
	
	
	public function actions() {
		return [
				
				// 图片上传
				'upload' => [ 
						'class' => 'common\widgets\file_upload\UploadAction', // 这里扩展地址别写错
						'config' => [ 
								'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}" 
						] 
				],
				
				// 百度编辑器
				'ueditor' => [ 
						'class' => 'common\widgets\ueditor\UeditorAction',
						'config' => [
								// 上传图片配置
								'imageUrlPrefix' => "", /* 图片访问路径前缀 */
								'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
						] 
				] 
		];
	}
	/**
	* 文章列表
	*/
	public function actionIndex(){
		if(isset($_GET['tag'])&&!empty($_GET['tag'])){
			$postTag['tag'] = $_GET['tag'];
			return $this->render('index',['postTag'=>$postTag]);
		}
		return $this->render('index');
	}
	
	/**
	* 创建文章
	*/
	public function actionCreate(){
		
		$model = new PostForm();
		
		//定义场景
		$model->setScenario(PostForm::SCENARIOS_CREATE);
		
		if($model->load(Yii::$app->request->post()) && $model->validate()){
			if(!$model->create()){
				Yii::$app->session->setFlash('warning',$model->_lastError);
			}else{
				return $this->redirect(['post/view','id'=>$model->id]);
			}
		}
		
		$cat = CatModel::getAllcats();
		return $this->render('create',['model'=>$model,'cat'=>$cat]);
	}
	
	/**
	 * 文章详情
	 * @param unknown $id
	 */
	public function actionView($id){
		$model = new PostForm();
		$data = $model->getViewById($id);
		
		//文章统计
		$model = new PostExtends();
		$model->upCount(['post_id'=>$id],'browser',1);
		
		return $this->render('view',['data'=>$data]);
	}
	
}

?>