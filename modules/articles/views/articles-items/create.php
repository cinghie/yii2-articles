<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\articles\models\ArticlesItems $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Articles Items',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
