<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
        <?php
        $items = [];
        if (Yii::$app->user->can('roles_view')){
            $items[] = ['label' => '&raquo; Роли Пользователей', 'url' => ['/rbac/roles']];
        }
        if (Yii::$app->user->can('rules_view')){
            $items[] = ['label' => '&raquo; Правила доступа', 'url' => ['/rbac/rules']];
        }
        if (Yii::$app->user->can('permissions_view')){
            $items[] = ['label' => '&raquo; Права доступа', 'url' => ['/rbac']];
        }
        $items[] = ['label' => '&raquo; Пользователи', 'url' => ['/users']];

        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => ['/'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav side-nav'],
            'encodeLabels' => false,
            'items' => $items
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => [
                ['label' => '<i class="glyphicon glyphicon-user"></i> ' . Yii::$app->user->identity->login, 'items' => [
                    [
                        'label' => '<i class="glyphicon glyphicon-cog"></i> Настройки',
                        'url' => [
                            '/users/default/update',
                            'id' => Yii::$app->user->identity->getId()
                        ]
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => '<i class="glyphicon glyphicon-log-out"></i> Выход',
                        'url' => ['/users/user/logout']
                    ],
                ]],
            ]
        ]);

        NavBar::end();
        ?>

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
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>