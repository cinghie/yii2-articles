<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var cinghie\articles\models\Items $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Items',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
