<?php

namespace frontend\widgets\post;

/**
 * 文章列表组件
 */
use Yii;
use yii\base\Widget;
use common\models\PostModel;
use frontend\models\PostForm;
use yii\data\Pagination;
use yii\helpers\Url;

class PostWidget extends Widget {
	/**
	 * 文章列表标题
	 * @var unknown
	 */
	public $title = '';
	
	/**
	 * 数据显示条数
	 * @var unknown
	 */
	public $limit = 5;
	
	/**
	 * 是否显示更多
	 * @var unknown
	 */
	public $more = true;
	
	/**
	 * 是否显示分页
	 * @var unknown
	 */
	public $page = true;
	
	/**
	 * 根据标签找文章
	 */
	public $tag = '';
	
	/**
	 * (non-PHPdoc)组件默认入口
	 * @see \yii\base\Widget::run()
	 */
	public function run() {
		//获取当前页数，如果没有，默认为1
		$curPage = yii::$app->request->get('page',1);
		
// 		if($tag == ''){
			
// 		}
		
		//查询条件 is_valid字段为已发布的文章
		$cond = ['=','is_valid',PostModel::IS_VALID];
		$res = PostForm::getList($cond,$curPage,$this->limit);
		
		$result['title'] = $this->title?: "最新文章";
		$result['more'] = Url::to(['post/index']);
		$result['body'] = $res['data']?:[];
		
		//条件控制显示分页
		if($this->page){//              ↓总记录数                                                 ↓每页显示条数
			$pages = new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
			$result['page'] = $pages;
		}
		
		return $this->render ( 'index', ['data'=>$result]);
	}
	
}