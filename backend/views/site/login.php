<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params ['breadcrumbs'] [] = $this->title;
?>
<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
	<div class="panel-heading">
		<h4 class="panel-title">你好，朋友！</h4>
	</div>
	<div class="panel-body">
		<button class="btn btn-primary btn-quirk btn-fb btn-block">联系我们</button>
		<div class="or">or</div>
 			<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

 					<!-- ↓在控件中添加配置 -->
               <?= $form->field($model, 'username', [
               		'inputOptions' => ['placeholder'=>'请输入用户名'],
               		'inputTemplate' => '<div class="input-group">
               								<span class="input-group-addon"><i class="fa fa-user"></i></span>{input}
               							</div>'
               ])->label(false)?>
				<!-- ↑控制输入框顶上的lable标签不显示 -->
               	
               		<!-- ↓在控件中添加配置 -->
               <?= $form->field($model, 'password',[
               		'inputOptions' => ['placeholder'=>'请输入密码'],
               		'inputTemplate' => '<div class="input-group">
               								<span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}
               							</div>'
               ])->passwordInput()->label(false)?>
								<!-- ↑控制输入框顶上的lable标签不显示 -->
               
               <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'记住账户'])?>

               <div class="form-group">
                   <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-success btn-block', 'name' => 'login-button'])?>
               </div>

           <?php ActiveForm::end(); ?>
           <hr class="invisible">
           <div>
           		<a href="#" class="btn btn-default btn-quirk btn-stroke btn-stroke-thin btn-block">Not A Member,Singup Now</a>
           </div>
    </div>
</div>
<!-- panel -->


