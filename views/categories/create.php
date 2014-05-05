<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var cinghie\articles\models\Categories $model
 */

$this->title = Yii::t('articles.message', 'Create Category', [
  'modelClass' => 'Categories',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles.message', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

	<div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
