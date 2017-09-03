<?php
use yii\helpers\Url;
?>
<div class="panel">
	<div id="carousel-example-generic" class="carousel slide"
		data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
  			<?php foreach ($data['items'] as $k =>$item):?>
    		<li data-target="#carousel-example-generic" data-slide-to=<?php echo $k?>
				class="<?php echo (isset($item['active']) &&$item['active'])?'active':'' ?>"></li>
    		<?php endforeach;?>
  		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
  			<?php foreach ($data['items'] as $item) :?>
    			<div
				class="<?php echo (isset($item['active']) && $item['active'])?'item active':'item' ?>">
				<a href="<?php echo Url::to($item['url'])?>"> <img
					src="<?php echo $item['image_url']?>"
					alt="<?php echo $item['label']?>">
					<div class="carousel-caption">
						<?php echo $item['html']?>
					</div>
				</a>
			</div>
    		<?php endforeach;?>
    	</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic"
			role="button" data-slide="prev"> 
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span
			class="sr-only">Previous</span> </a> 
			
		<a class="right carousel-control"
			href="#carousel-example-generic" role="button" data-slide="next"> 
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span> </a>
	</div>
</div>