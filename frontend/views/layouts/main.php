<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\controllers\SiteController;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('common','Blog'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $leftmenus = [
        ['label' => Yii::t('common','Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('common','Article'), 'url' => ['/post/index']],
    ];
    if (Yii::$app->user->isGuest) {//未登录
        $rightmenus[] = ['label' => Yii::t('common','Signup'), 'url' => ['/site/signup']];
        $rightmenus[] = ['label' => Yii::t('common','Login'), 'url' => ['/site/login']];
    } else {//已登录
       /*$rightmenus[] = 
       		'<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::t('common','Logout').' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';*/
    	
    	$avatarImg = (file_exists(Yii::getAlias('@webroot').Yii::$app->user->identity->avatar) 
    					&& Yii::$app->user->identity->avatar != '')?
    					Yii::$app->user->identity->avatar : Yii::$app->params['default_avatar_img'];
    	$rightmenus[]=[
    			'label'=>'<img src = "'.$avatarImg.'" alt="'.Yii::$app->user->identity->username.'">',
    			'linkOptions'=>['class'=>'avatar'],
    			'items'=>[
    					['label'=>'<i class="fa fa-user"></i>个人中心','url'=>['/site/logout']],
    					['label'=>'<i class="fa fa-sign-out"></i>退出','url'=>['/site/logout'],'linkOptins'=>['data-method'=>'post']],
    			],
    	];
    }
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftmenus,
	]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
		'encodeLabels'=>false,
        'items' => $rightmenus,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"> Zxy    ---<?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
