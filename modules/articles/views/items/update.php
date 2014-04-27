<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\Items $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
  'modelClass' => 'Items',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
