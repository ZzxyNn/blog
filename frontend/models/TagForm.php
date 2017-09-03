<?php 
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\TagModel;

/**
 * 标签的表单模型
 */
class TagForm extends Model{
	public $id;
	
	public $tags;
	
	public function rules(){
		return [
				['tags','required'],
				['tags','each','rule'=>['string']],
		];
	}
	
	/**
	 * 保存所有标签
	 * return 返回所有标签的id数组
	 */
	public function saveTags(){
		$ids = [];

		if(!empty($this->tags)){
			//循环调用保存单个标签方法保存每一个标签
			foreach ($this->tags as $tag){
				$ids[] = $this->_saveTag($tag);
			}
		}
		
		//返回所有标签的id数组
		return $ids;
	}
	
	/**
	 * 保存单个标签
	 * @param unknown $tag
	 */
	private function _saveTag($tag){
		//标签对象的数据模型
		$model = new TagModel();
		
		//获取已有的标签名的id
		$res = $model->find()->where(['tag_name' => $tag])->one();
		//如果没有该标签 则存入一个新标签
		if(!$res){
			$model->tag_name = $tag;
			$model->post_num = 1;
			if(!$model->save()){
				throw new \Exception(Yii::t('common', 'Tags save failed!'));
			}
			//返回新插入的标签id
			return $model->id;
		}
		else{//如果有该标签 则该标签对应文章数+1
			$res->updateCounters(['post_num' => 1]);
		}
		//返回已有标签id
		return $res->id;
	}
}

?>