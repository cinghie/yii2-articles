<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var cinghie\articles\models\ItemsSearch $searchModel
 */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Items',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'catid',
            'userid',
            'published',
            // 'introtext:ntext',
            // 'fulltext:ntext',
            // 'image',
            // 'image_caption:ntext',
            // 'image_credits',
            // 'video:ntext',
            // 'video_caption:ntext',
            // 'video_credits',
            // 'created',
            // 'created_by',
            // 'modified',
            // 'modified_by',
            // 'access',
            // 'ordering',
            // 'hits',
            // 'alias',
            // 'metadesc:ntext',
            // 'metakey:ntext',
            // 'robots',
            // 'author',
            // 'copyright',
            // 'params:ntext',
            // 'language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
