<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = Yii::t ( 'common', 'Signup' );
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="site-signup">
	<h1><?= Html::encode($this->title) ?></h1>

	<p><?=Yii::t('common','Please fill out the following fields to signup');?></p>

	<div class="row">
    	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="col-lg-5">
            
				
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])?>

                <?= $form->field($model, 'email')?>

                <?= $form->field($model, 'password')->passwordInput()?>
                
                <?= $form->field($model, 'rePassword')->passwordInput()?>
                                                       
                <?=$form->field ( $model, 'verifyCode' )->widget ( Captcha::className (), 
                		['imageOptions' => [ 'alt' => '点击换图','title' => '点击换图','style' => 'cursor:pointer' ] ] );?>
                                                                                        <!-- ↑改变鼠标箭头样式 -->
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('common', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button'])?>
                </div>
		</div>
		<div class="col-lg-3">
			<!-- 头像 -->
				<?=$form->field ( $model, 'avatar' )->widget ( 'common\widgets\file_upload\FileUpload', [ 'config' => [ ] ] )?>
			<?php ActiveForm::end(); ?>
        </div>
	</div>
</div>
