<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\admin */

$this->title = '管理员'.$model->id;
$this->params['breadcrumbs'][] = ['label' => '管理员信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
        	'email',
        	'status'=>[
            		'attribute'=>'status',
            		'value'=>function($model){
            					return ($model->status == 10) ? '已激活' : '未激活';
    						}
    		],
            'created_at'=>[
            		'attribute'=>'created_at',
            		'format'=>['date','php:Y-m-d H:i:s']
    		],
            'updated_at'=>[
            		'attribute'=>'updated_at',
            		'format'=>['date','php:Y-m-d H:i:s']
    		],
        ],
    ]) ?>

</div>
