<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\CatModel;

/* @var $this yii\web\View */
/* @var $model common\models\CatModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_name')->dropDownList(CatModel::getAllcats()) ?>

    <div class="form-group">
        <?= Html::submitButton('修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
