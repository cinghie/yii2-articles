<?php

use yii\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>

<div class="categories-create">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [ 'model' => $model, ]) ?>

</div>
