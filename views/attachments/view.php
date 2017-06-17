<?php

/**
 * @var $model cinghie\articles\models\Attachments
 */

use kartik\helpers\Html;
use yii\widgets\DetailView;

// Set Title and Breadcrumbs
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="attachments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'item_id',
            'filename',
            'title',
            'titleAttribute:ntext',
            'hits',
        ],
    ]) ?>

</div>
