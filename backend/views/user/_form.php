<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\user */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id')->textInput(['readonly'=>true])?>
    
    <?= $form->field($model, 'username')->textInput(['readonly'=>true])?>
    
    <?= $form->field($model, 'email')->textInput(['readonly'=>true])?>

    <?= $form->field($model, 'status')->dropDownList(['0'=>'未激活','10'=>'已激活']) ?>

    <div class="form-group">
        <?= Html::submitButton('修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
