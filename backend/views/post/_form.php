<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CatModel;

/* @var $this yii\web\View */
/* @var $model common\models\PostModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'summary')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6,'readonly'=>true]) ?>

    <?= $form->field($model, 'label_img')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(CatModel::getAllcats()) ?>

    <?= $form->field($model, 'user_id')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'is_valid')->dropDownList(['0'=>'无效','1'=>'有效']) ?>

    <?= $form->field($model, 'created_at')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton('更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
