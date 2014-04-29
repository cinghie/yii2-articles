<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\Categories $model
 */

$this->title = Yii::t('articles.message', 'Update {modelClass}: ', [
  'modelClass' => 'Categories',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles.message', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('articles.message', 'Update');
?>
<div class="categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
