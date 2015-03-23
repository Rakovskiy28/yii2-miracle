<?php
/* @var $this yii\web\View */

$this->title = 'Главная';
?>

    <h1>Добро пожаловать</h1>

<?php if (Yii::$app->user->isGuest): ?>
    Вы гость
<?php else: ?>
    <strong>Логин:</strong> <?= Yii::$app->user->identity->login; ?>
<?php endif; ?>