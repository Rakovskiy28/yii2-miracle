<?php

use yii\helpers\Html;
use themes\bare\assets\AppAsset;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
    </style>
    <?php $this->head() ?>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Yii::$app->urlManager->createUrl(['/']) ?>"><?= Yii::$app->name ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right navbar-user">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/users/guest/login']) ?>"><i class="fa fa-lock"></i> Вход</a>
                    </li>
                    <li>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/users/guest/registration']) ?>"><i class="fa fa-plus"></i> Регистрация</a>
                    </li>
                <?php else: ?>
                    <?php if (Yii::$app->user->can('backend_access')): ?>
                        <li>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/backend']) ?>"><i class="fa fa-th-large"></i> Админка</a>
                        </li>
                    <?php endif; ?>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= Yii::$app->user->identity->login ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= Yii::$app->urlManager->createUrl(['/users/default/update', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-gears"></i> Настройки</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= Yii::$app->urlManager->createUrl(['/users/user/logout']) ?>"><i class="fa fa-power-off"></i> Выход</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-12">
            <?php if (isset($this->params['pageTitle'])): ?>
                <h1><?= Html::encode($this->params['pageTitle']); ?></h1>
            <?php endif; ?>
            <?= Breadcrumbs::widget([
                'encodeLabels' => false,
                'homeLink' => [
                    'label' => 'Главная',
                    'url' => ['/']
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
            ]) ?>
            <?= $content ?>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
