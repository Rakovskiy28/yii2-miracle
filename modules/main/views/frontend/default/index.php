<?php
/* @var $this yii\web\View */

$this->title = 'Главная';
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MiracleCMS, CMS, Yii, Yii2, Framework'
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'MiracleCMS, CMS на Yii2, пример сайта на Yii'
]);
?>

<div class="col-lg-12">
    <div class="text-center">
        <h1>Miracle CMS</h1>
    </div>
    <div class="bs-example">
        <div class="jumbotron">
            <h1>Поздравляем!</h1>
            <p>Установка успешно завершена.</p>
            <p><a href="/backend" class="btn btn-primary btn-lg">Перейти в админку</a></p>
        </div>
    </div>
</div>