<?php
namespace frontend\models;

use Yii;
use common\models\FeedModel;
use yii\base\Object;

class FeedForm extends FeedModel{
	
	public $content;
	
	public $_lastError;
	
	public function rules(){
		return [
				[['content'],'required'],
				[['content'],'string','max'=>255],
		];
	}
	
	public function attributeLabels(){
		return [
				'id'=>'ID',
				'content'=>Yii::t('common', 'Content'),
		];
	}
	
	public function create(){
		try {
			$model = new FeedModel();
			
			$model->user_id = Yii::$app->user->identity->id;
			$model->content = $this->content;
			$model->created_at = time();
			
			if(!$model->save()){
				throw new \Exception(Yii::t('common', 'Message release failed!'));
			}
			
			return true;
			
		} catch (\Exception $e) {
			$this->_lastError = $e->getMessage();
			return false;
		}
	}
	
	public function getList(){
		$model = new FeedModel();
		$res = $model->find()
			->limit(10)
			->with('user')
			->orderBy(['id'=>SORT_DESC])
			->asArray()
			->all();
		
		//格式化
		$res = self::__formatList($res);
		
		return $res ? $res : [];
	}
	
	/**
	 * 数据格式化
	 * @param unknown $data
	 */
	private function __formatList($data) {
		
		foreach ( $data as &$list ) {
			if (isset ( $list['user'] ) && ! empty ( $list['user'] )) {
				$list ['user_id'] = $list ['user'] ['id'];
				$list ['user_name'] = $list ['user'] ['username'];
				
				//头像检测
				if(file_exists(Yii::getAlias('@webroot').$list ['user'] ['avatar']) && $list ['user'] ['avatar']!=''){
					$list ['user_ava'] = $list ['user'] ['avatar'];
				}else{
					$list ['user_ava'] = Yii::$app->params['default_avatar_img'];
				}
				
			}
			unset($list['user']);
		}
		
		return $data;
	}
	
	
}