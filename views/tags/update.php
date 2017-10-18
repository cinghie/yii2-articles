<?php

/**
 * @var $model cinghie\articles\models\Tags
 */

use kartik\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Update Tags') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('traits','Update');

?>

<div class="tags-update">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
