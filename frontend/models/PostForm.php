<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\PostModel;
use yii\base\Object;
use common\models\PostTagModel;
use yii\db\Exception;
use frontend\models\TagForm;
use yii\db\Query;

/**
 * 文章表单模型
 */
class PostForm extends Model {
	public $id;
	public $title;
	public $content;
	public $label_img;
	public $cat_id;
	public $tags;
	public $_lastError = "";
	
	/**
	 * 定义场景
	 * SCENARIOS_CREATE 创建
	 * SCENARIOS_UPDATE 更新
	 *
	 * @var unknown
	 */
	const SCENARIOS_CREATE = 'create';
	const SCENARIOS_UPDATE = 'update';
	
	/**
	 * 定义事件
	 * EVENT_AFTER_CREATE 文章创建之后
	 * EVENT_AFTER_UPDATE 文章更新之后
	 *
	 * @var unknown
	 */
	const EVENT_AFTER_CREATE = 'evenAfterCreate';
	const EVENT_AFTER_UPDATE = 'evenAfterUpdate';
	
	/**
	 * 场景设置
	 *
	 * @see \yii\base\Model::scenarios()
	 */
	public function scenarios() {
		$scenarios = [ 
				self::SCENARIOS_CREATE => [ 
						'title',
						'content',
						'label_img',
						'cat_id',
						'tags' 
				],
				self::SCENARIOS_UPDATE => [ 
						'title',
						'content',
						'label_img',
						'cat_id',
						'tags' 
				] 
		];
		
		return array_merge ( parent::scenarios (), $scenarios );
	}
	public function rules() {
		return [ 
				[ 
						[ 
								'id',
								'title',
								'content',
								'cat_id' 
						],
						'required' 
				],
				[ 
						[ 
								'id',
								'cat_id' 
						],
						'integer' 
				],
				[ 
						'title',
						'string',
						'min' => '4',
						'max' => '50' 
				] 
		];
	}
	public function attributeLabels() {
		return [ 
				'id' => Yii::t ( 'common', 'ID' ),
				'title' => Yii::t ( 'common', 'Title' ),
				'content' => Yii::t ( 'common', 'Content' ),
				'label_img' => Yii::t ( 'common', 'Label_Img' ),
				'tags' => Yii::t ( 'common', 'tags' ),
				'cat_id' => Yii::t ( 'common', 'cat_id' ) 
		];
	}
	
	/**
	 * 文章创建
	 *
	 * @throws \Exception
	 */
	public function create() {
		$transaction = Yii::$app->db->beginTransaction (); // 开始事务
		
		try {
			$model = new PostModel ();
			$model->setAttributes ( $this->attributes );
			$model->summary = $this->_getSummary ();
			$model->user_id = Yii::$app->user->identity->id; // 获取用户id
			$model->user_name = Yii::$app->user->identity->username; // 获取用户名
			$model->is_valid = PostModel::IS_VALID;
			
			if (! $model->save ()) {
				throw new \Exception ( Yii::t ( 'common', 'Article save failed!' ) );
			}
			
			// 记录当前文章id
			$this->id = $model->id;
			
			// array_merge()-->合并两个数组，若有相同key，则用后者
			$data = array_merge ( $this->getAttributes (), $model->getAttributes () );
		
			// 调用事件
			$this->_eventAfterCreate ( $data );
			
			// 提交事务
			$transaction->commit ();
			return true;
		} catch ( \Exception $e ) {
			// 事务回滚
			$transaction->rollBack ();
			
			// 记录错误信息
			$this->_lastError = $e->getMessage ();
			return false;
		}
	}
	
	/**
	 * 获取文章内容摘要
	 */
	private function _getSummary($s = 0, $e = 90, $char = 'utf-8') {
		if (empty ( $this->content ))
			return null;
		
		return (mb_substr ( str_replace ( '&nbsp', '', strip_tags ( $this->content ) ), $s, $e, $char ));
	}
	
	/**
	 * 文章创建之后的事件
	 */
	public function _eventAfterCreate($data) {
		// 添加事件
		$this->on ( self::EVENT_AFTER_CREATE, [ $this,'_eventAddTag'], $data );
		// 触发事件 
		$this->trigger ( self::EVENT_AFTER_CREATE );
	}
	
	/**
	 * 添加标签和标签与文章之间的联系
	 *
	 * @param unknown $event
	 *        	触发事件时传入的数据参数(包含所有文章信息和标签信息)
	 * @throws \Exception 保存标签与文章关系时失败抛出的异常
	 */
	public function _eventAddTag($event) {
		// 保存标签
		$tag = new TagForm ();
		$tag->tags = $event->data ['tags'];
		
		// 调用TagForm里的方法先保存每一个标签
		$tagids = $tag->saveTags ();
		
		/* -----分割线---以上保存好每个标签。。。以下保存标签和文章的关联关系--------------- */
		
		// 删除原先的关联关系
		if (! empty ( $event->data ['id'] )) {
			PostTagModel::deleteAll ( [ 
					'post_id' => $event->data ['id'] 
			] );
		}
		
		// 批量保存文章和标签的关联关系
		if (! empty ( $tagids )) {
			foreach ( $tagids as $key => $value ) {
				$row [$key] ['post_id'] = $this->id; // =>$row[0]['post_id']=>文章id
				$row [$key] ['tag_id'] = $value; // =>$row[0]['tag_id']=>标签id
			}
			
			// 批量插入
			$res = (new Query ())->createCommand ()->batchInsert ( PostTagModel::tableName (), [ 
					'post_id',
					'tag_id' 
			], $row )->execute ();
			
			// 返回结果
			if (! $res) {
				throw new \Exception ( Yii::t ( 'common', 'Tags_Posts save failed!' ) );
			}
		}
	}
	public function getViewById($id) {
		// ↓联合查询 ↓对应model类中get方法
		$res = PostModel::find ()->with ( 'relate.tag', 'extend' )->where ( [ 
				'id' => $id 
		] )->asArray ()->one ();
		// ↑对应model中的get方法
		if (! $res) {
			throw new NotFoundHttpException ( "文章不存在！" );
		}
		// 处理标签格式
		$res ['tags'] = [ ]; // 添加一个空数组装标签
		if (isset ( $res ['relate'] ) && ! empty ( $res ['relate'] )) {
			foreach ( $res ['relate'] as $tag ) {
				$res ['tags'] [] = $tag ['tag'] ['tag_name'];
			}
		}
		unset ( $res ['relate'] );
		
		return $res;
	}
	public static function getList($cond, $curPage = 1, $pageSize = 5, $orderBy = ['id'=>SORT_DESC]) {
		$model = new PostModel ();
		
		$select = [ 
				'id',
				'title',
				'summary',
				'label_img',
				'cat_id',
				'user_id',
				'user_name',
				'is_valid',
				'created_at',
				'updated_at' 
		];
		$query = $model->find ()
			->select ( $select )
			->where ( $cond )
			->with ( 'relate.tag', 'extend' )
			->orderBy ( $orderBy );
		
		//获取分页数据
		$res = $model->getPages($query,$curPage,$pageSize);
		//格式化
		$res['data'] = self::__formatList($res['data']);
		
		return $res;
	}
	
	/**
	 * 数据格式化
	 * @param unknown $data
	 */
	public static function __formatList($data){
		
		foreach($data as &$list){
			$list['tags'] = [];
			if(isset($list['relate']) && !empty($list['relate'])){
				foreach ($list['relate'] as $lt){
					$list['tags'][] = $lt['tag']['tag_name'];
				}
			}
			unset($data['relate']);
		}
		return $data;
	}
}
?>