<?php

namespace frontend\widgets\banner;

use Yii;
use yii\bootstrap\Widget;

class BannerWidget extends Widget {
	/**
	 * 图片数量
	 * @var unknown
	 */
	public $img_num = 5;
	
	/**
	 * 图片轮播集合
	 * @var unknown
	 */
	public $items = [ ];
	
	public function init() {
		$files = $this->randImg($this->img_num);
		
		for($i = 0; $i < $this->img_num; $i ++) {
			$this->items [$i] = [ 
					'label' => 'demo',    
			                                        //         ↓ 拼接图片名，在所有图片中随机抽选图片
					'image_url' => '/statics/images/banner/'.$files[$i],
					'url' => [ 
							'site/index' 
					],
					'html' => '',
					'active' => '' //默认图片属性
			];
		}
		//设置默认图片
		$this->items [0] ['active'] = 'active';
	}
	public function run() {
		$data ['items'] = $this->items;
		
		return $this->render ( 'index', ['data' => $data ] );
	}
	
	public function randImg($img_num){
		//扫描图片文件夹所有图片
		$files = scandir(Yii::getAlias('@webroot').'/statics/images/banner');
		
		//所有图片名数组       ↓ 去除scandir方法产生的 '.','..'这两个数据
		$files = array_diff($files, array('.','..'));
		
		$img_sum = count($files) + 1;
		
		//得一个范围 2-$img_sum大小，步长为1的数组
		$numbers = range (2,$img_sum);
		
		//shuffle 将数组顺序随即打乱
		shuffle ($numbers);
		
		//array_slice 从正数第一位取 $numbers数组 中的 $img_num个 数据
		$result = array_slice($numbers,0,$img_num);
		
		foreach ($result as $k => $res){
			$imgs[$k] = $files[$res];
		}
		
		return $imgs;
	}
}
