<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\Categories $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Categories',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
