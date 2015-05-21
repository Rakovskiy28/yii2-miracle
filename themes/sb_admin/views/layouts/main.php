<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use themes\sb_admin\assets\AppAsset;

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
    <?php $this->head() ?>
</head>
<body>

<div id="wrapper">

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Url::to(['/']) ?>"><?= Yii::$app->name ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">

                <?php if (Yii::$app->user->can('roles_view')): ?>
                    <li><a href="<?= Url::to(['/rbac/roles']) ?>">&raquo; Роли пользователей</a></li>
                <?php endif ?>

                <?php if (Yii::$app->user->can('rules_view')): ?>
                    <li><a href="<?= Url::to(['/rbac/rules']) ?>">&raquo; Правила доступа</a></li>
                <?php endif ?>

                <?php if (Yii::$app->user->can('permissions_view')): ?>
                    <li><a href="<?= Url::to(['/rbac']) ?>">&raquo; Права доступа</a></li>
                <?php endif ?>

                <li><a href="<?= Url::to(['/users']) ?>">&raquo; Пользователи</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right navbar-user">
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= Yii::$app->user->identity->login ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::to(['/users/default/update', 'id' => Yii::$app->user->id]) ?>"><i class="fa fa-user"></i> Настройки</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= Url::to(['/users/user/logout']) ?>"><i class="fa fa-power-off"></i> Выход</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($this->params['pageTitle'])): ?>
                    <h1><?= Html::encode($this->params['pageTitle']); ?></h1>
                <?php endif; ?>
                <?= Breadcrumbs::widget([
                    'encodeLabels' => false,
                    'homeLink' => [
                        'label' => 'Админка',
                        'url' => ['/']
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                ]) ?>
                <?= $content ?>
            </div>
        </div><!-- /.row -->

    </div><!-- /#page-wrapper -->

</div><!-- /#wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
