<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller{
	public function actionInit() {
		$auth = Yii::$app->authManager;
		
		//添加 "createPost" 权限
		$createPost = $auth->createPermission('createPost');
		$createPost->description = '新增文章';
		$auth->add($createPost);
		
		//添加 "updatePost" 权限
		$updatePost = $auth->createPermission('updatePost');
		$updatePost->description = '修改文章';
		$auth->add($updatePost);
		
		//添加 "deletePOst" 权限
		$deletePost = $auth->createPermission('deletePost');
		$deletePost->description = '删除文章';
		$auth->add($deletePost);
		
		//添加 "postAdmin" 角色并授予 "updatePOst" "deletePOst" "createPost"权限
		$postAdmin = $auth->createRole('postAdmin');
		$postAdmin->description = '文章管理员';
		$auth->add($postAdmin);
		$auth->addChild($postAdmin, $createPost);
		$auth->addChild($postAdmin, $updatePost);
		$auth->addChild($postAdmin, $deletePost);
		
		//添加 "postOperator" 角色并授予 "deletePOst"权限
		$postOperator = $auth->createRole('postOperator');
		$postOperator->description = '文章操作员';
		$auth->add($postOperator);
		$auth->addChild($postOperator, $deletePost);
		
		//添加 "admin" 系统管理员并授予所有权限
		$admin = $auth->createRole('admin');
		$admin->description = '系统管理员';
		$auth->add($admin);
		$auth->addChild($admin, $postAdmin);
		$auth->addChild($admin, $postOperator);
		
		//为用户指派角色，其中1和2是由IdentityInerface::getId() 返回的id
		$auth->assign($admin, 1);
		$auth->assign($postAdmin, 3);
		$auth->assign($postOperator, 4);
	}
}
