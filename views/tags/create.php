<?php

use yii\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Create Tags');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tags-create">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
