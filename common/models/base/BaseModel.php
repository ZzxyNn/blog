<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord {
	
	/**
	 * 获取分页数据
	 * @param unknown $query
	 * @param number $curPage
	 * @param number $pageSize
	 * @param string $search
	 */
	public function getPages($query, $curPage = 1, $pageSize = 10, $search = null) {
		
		// 如果有搜索，将搜索条件加入到查询条件里
		if ($search) {
			$query = $query->andFilerWhere ( $search );
		}
		
		//查询数据的总行数
		$data ['count'] = $query->count ();
		
		// 如果数据行数为空，则对应返回空数据去处理
		if (!$data ['count']) {
			return [ 
					'count' => 0,
					'curPage' => $curPage,
					'pageSize' => $pageSize,
					'start' => 0, // 起始条数
					'end' => 0, // 结束条数
					'data' => [ ] 
			];
		}
		
		// 超过实际页数，不去curPage为当前页
		$curPage = (ceil ( $data ['count'] / $pageSize ) < $curPage) ? ceil ( $data ['count'] / $pageSize ) : $curPage;
		
		//当前页
		$data ['curPage'] = $curPage;
		
		//每页显示条数
		$data ['pageSize'] = $pageSize;
		
		// 起始条数 从第1条开始
		$data ['start'] = ($curPage - 1) * $pageSize + 1;
		
		// 结束条数
		$data ['end'] = (ceil ( $data ['count'] / $pageSize ) == $curPage) 
			? $data ['count'] : ($curPage - 1) * $pageSize + $pageSize;
		
		//数据
		$data['data'] = $query
			->offset(($curPage-1)*$pageSize)//设置开始条数 从第0条开始
			->limit($pageSize)   //限制取多少条数
			->asArray()
			->all();
		
		return $data;
		
	}
}
?>