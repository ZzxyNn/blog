<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = Yii::t('common', 'Create');
$this->params['breadcrumbs'][] = ['label'=>Yii::t('common', 'Title'),'url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-lg-9">
		<div class="panel-title box-title">
			<h1>创建文章</h1>
		</div>
		<div class="panel-body">
			<?php $form=ActiveForm::begin()?>
			
			<!--标题框  -->
			<?=$form->field($model,'title')->textinput(['maxlength'=>true])?>
			<div class="row">
				<div class="col-lg-6">
					<div>
					<!-- 分类 -->
					<?=$form->field($model,'cat_id')->dropDownList($cat)?>
					</div>
					
					<div>
					<!-- 标签 -->
					<?=$form->field($model,'tags')->widget('common\widgets\tags\TagWidget')?>
					</div>
					
				</div>
				
				<div class="col-lg-6">
					<!-- 标签图 -->
					<?=$form->field ( $model, 'label_img' )->widget ( 'common\widgets\file_upload\FileUpload', 
							[ 'config' => [ ] ] )?>
				</div>
			</div>
			<!-- 富文本编辑器 -->
			<?=$form->field ( $model, 'content' )->widget ( 'common\widgets\ueditor\Ueditor', 
					[ 'options' => [ 'initialFrameHeight' => 450 ] ] )?>
			
			<div class="form-group">
				<?=Html::submitButton("发布",['class'=>'btn btn-success'])?>
			</div>
			
			<?php ActiveForm::end()?>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="panel-title box-title">
			<h3>注意事项</h3>
		</div>
	</div>
</div>