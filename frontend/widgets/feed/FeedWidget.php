<?php
namespace frontend\widgets\feed;

use Yii;
use yii\bootstrap\Widget;
use frontend\models\FeedForm;

class FeedWidget extends Widget{
	
	public function run(){
		$model = new FeedForm();
		$data['feed'] = $model->getList();
		
		return $this->render('index',['data'=>$data]);
		
	}
}