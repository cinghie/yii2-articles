<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var cinghie\articles\models\Items $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

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
            'title',
            'catid',
            'userid',
            'published',
            'introtext:ntext',
            'fulltext:ntext',
            'image',
            'image_caption:ntext',
            'image_credits',
            'video:ntext',
            'video_caption:ntext',
            'video_credits',
            'created',
            'created_by',
            'modified',
            'modified_by',
            'access',
            'ordering',
            'hits',
            'alias',
            'metadesc:ntext',
            'metakey:ntext',
            'robots',
            'author',
            'copyright',
            'params:ntext',
            'language',
        ],
    ]) ?>

</div>
