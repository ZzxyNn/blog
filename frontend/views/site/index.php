<?php

use frontend\widgets\banner\BannerWidget;
use yii\base\Widget;
use frontend\widgets\post\PostWidget;
use frontend\widgets\feed\FeedWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;

$this->title = yii::t('common', 'Blog');
?>

<div class="row">
	<div class="col-lg-9">
			<!--图片滚动栏  -->
		<?=BannerWidget::widget(['img_num'=>5])?>
		
			<!-- 文章显示列表 -->
		<?=PostWidget::widget(['page'=>false,'limit'=>3])?>
	</div>

	<div class="col-lg-3">
			<!--留言板  -->
		<?php echo FeedWidget::widget();?>
				
			<!--热门文章  -->
		<?php echo HotWidget::widget(['limit' => 5])?>
		
			<!-- 标签云 -->
		<?php echo TagWidget::widget()?>
	</div>
</div>

