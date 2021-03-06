<?php
use yii\helpers\Url;

$this->title = $data ['title'];
$this->params ['breadcrumbs'] [] = [ 
		'label' => Yii::t ( 'common', 'Article' ),
		'url' => ['post/index' ] 
];
$this->params ['breadcrumbs'] [] = $this->title;
?>

<div class="row">

	<div class="col-lg-9">
		<div class="page-title">
			<h1><?=$data['title']?></h1>

			<span>作者：<?=$data['user_name']?></span> 
			<span>发布：<?=date('Y-m-d',$data['created_at'])?></span>
			<span>浏览：<?=isset($data['extend']['browser'])?$data['extend']['browser']:0?>次</span>
		</div>
		
		<div class="page-content">
			<?=$data['content']?>
		</div>
		
		<div class="page-tag">
		标签：
			<?php foreach ($data['tags'] as $tag):?>
			<span><?php echo $tag?></span>
			<?php endforeach;?>
		</div>
	</div>

	<div class="col-lg-3">
	<div class="panel">
        <?php if(!\Yii::$app->user->isGuest):?>    
            <?php if (\Yii::$app->user->identity->id == $data['user_id']):?>
                <a class="btn btn-info btn-block btn-post" href="<?=Url::to(['post/update', 'id' => $data['id']])?>">编辑文章</a>
            <?php endif;?>
        <?php endif;?>
        </div>
	</div>

</div>