<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '会员中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
<h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'email_validate_token:email',
            'email:email'=>[
            		'label'=>'邮箱地址',
            		'attribute'=>'email',
            		'filter'=>['@google.com'=>'@google.com','@qq.com'=>'@qq.com'],
            	],
            // 'role',
            'status'=>[
            		'label'=>'状态',
            		'attribute'=>'status',
            		'value'=>function($model){
								return ($model->status == 10) ? '已激活':'未激活';            		
            				},
            		'filter'=>['0'=>'未激活','10'=>'已激活'], //下拉框过滤器
        	],
            // 'avatar',
            // 'vip_lv',
            'created_at:datetime',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
             'template' =>'{update}',
            ],
        ],
    ]); ?>
</div>
