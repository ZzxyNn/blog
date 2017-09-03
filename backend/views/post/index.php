<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\base\Object;
use common\models\CatSearch;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章内容管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id'=>[
            		'attribute'=>'id',
            		'contentOptions'=>['width'=>'90px']
            ],
            'title'=>[
            	'attribute'=>'title',
            	'format'=>'raw',
            	'contentOptions'=>['width'=>'100px'],
            	'value'=>function ($model){
            				return '<a href="http://yii2.advanced.frontend:6699'.Url::to(['post/view','id'=>$model->id]).'">'.$model->title.'</a>';
            			}
        	],
            'summary'=>[
            		'attribute'=>'summary',
            		'value'=>function($model){
            					if(strlen($model->summary)>20){
            						return mb_substr($model->summary, 0,20,'utf-8').'......';
            					}
            					return $model->summary;
            				},
            		'contentOptions'=>['width'=>'400px'],
            ],
            //'content:ntext',
            //'label_img',
            'cat_name'=>[
            		'label'=>'分类名称',
            		'attribute'=>'cat_name',
            		'value'=>'cat.cat_name',//这里没有用原表名，很奇怪 //因为这里的cat.cat_name用的是postmodel里的getCat()关联函数
            		'contentOptions'=>['width'=>'90px'],
            		'filter'=>CatSearch::getAllCat(),
            ],
            // 'user_id',
            // 'user_name',
            'is_valid'=>[
            		'attribute'=>'is_valid',
            		'value'=>function ($model){
            					return ($model->is_valid)?'有效':'无效';
        					},
        					//↓ 设置‘无效’字段的css样式为深色背景
        			'contentOptions'=>function($model){
        						return (!$model->is_valid)?['class'=>'bg-danger','width'=>'90px']:['width'=>'90px'];
        					},
        			'filter'=>['0'=>'无效','1'=>'有效'],
        	],
            'created_at'=>[
            		'attribute'=>'created_at',
            		'format'=>['date','php:Y-m-d H:i:s'],
            		'contentOptions'=>['width'=>'90px'],
        	],
            'updated_at'=>[
            		'attribute'=>'updated_at',
            		'format'=>['date','php:Y-m-d H:i:s'],
            		'contentOptions'=>['width'=>'90px'],
        	],

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}{update}{delete}{approve}',
             'buttons' => [
             	'approve'=>function($url,$model,$key)
             		{
             			$options = [
             					'title' => '审核',
             					'aria-label' => '审核',
             					'data-confirm' => '你确定通过该文章吗？',
             					'data-method' => 'post',
             					'data-pjax' => '0',
             			];
             			return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
           			}
            ]
        					],
        ],
    ]); ?>
</div>
