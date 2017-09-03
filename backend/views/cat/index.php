<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CatModel;
use common\models\CatSearch;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'cat_name'=>[
            		'attribute'=>'cat_name',
            		'filter'=>CatSearch::getAllCat(),
    		],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
