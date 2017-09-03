<?php
use yii\helpers\Url;
use frontend\widgets\post\PostWidget;
use yii\base\Widget;
use frontend\widgets\hot\HotWidget;
?>
<div class="row">
	<div class="col-lg-9">
		<?php if(!empty($postTag) && isset($postTag)){
			echo PostWidget::widget([
					'limit'=>5,
					'title'=>'标签：'.$postTag['tag'],
					
			]);
		}?>
		<?=PostWidget::widget(['limit'=>5]);?>
	</div>

	<div class="col-lg-3">
		<?php if(!\Yii::$app->user->isGuest):?>    
            <a class="btn btn-success btn-block btn-post" href="<?=Url::to(['post/create'])?>">创建文章</a>
    	<?php endif;?>
    	<?php echo HotWidget::widget()?>
	</div>
</div>

	
