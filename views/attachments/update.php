<?php

/**
 * @var $model cinghie\articles\models\Attachments
 */

use kartik\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Update Attachments') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Attachments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="attachments-update">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
