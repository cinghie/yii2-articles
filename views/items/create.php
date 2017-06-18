<?php

/**
 * @var $model cinghie\articles\models\Items
 * @var $searchModel cinghie\articles\models\ItemsSearch
 * @var $this yii\web\View
 */

use kartik\helpers\Html;

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Create Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
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
