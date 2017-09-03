<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Admin;

/* @var $this yii\web\View */
/* @var $model common\models\admin */

$model = Admin::findOne($id);
$this->title = '修改管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->username]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="admin-update">

   <h1><?= Html::encode($this->title) ?></h1>

   <div class="admin-privilege-form">

	<?php $form = ActiveForm::begin(); ?>

		<?= Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray);?>
	
	    <div class="form-group">
	        <?= Html::submitButton('设置', ['class' =>'btn btn-primary']) ?>
	    </div>

    <?php ActiveForm::end(); ?>


</div>

</div>
