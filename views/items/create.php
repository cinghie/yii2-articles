<?php

use yii\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Create Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="items-create">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
