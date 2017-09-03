<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\user */

$this->title = '会员ID：'.$model->id;
$this->params['breadcrumbs'][] = ['label' => '会员详情', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定要删除该会员吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email_validate_token:email',
            'email:email',
            'role',
            'status'=>[
            		'attribute'=>'status',
            		'value'=>function($model){
            					return ($model->status == 10) ? '已激活' : '未激活';
    						}
    		],
            'avatar',
            'vip_lv',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
