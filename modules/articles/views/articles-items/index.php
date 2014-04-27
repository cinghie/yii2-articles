<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\articles\models\search\ArticlesItemsSearch $searchModel
 */

$this->title = Yii::t('app', 'Articles Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Articles Items',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'alias',
            'catid',
            'published',
            // 'introtext:ntext',
            // 'fulltext:ntext',
            // 'created',
            // 'created_by',
            // 'modified',
            // 'modified_by',
            // 'access',
            // 'ordering',
            // 'hits',
            // 'params:ntext',
            // 'metadesc:ntext',
            // 'metakey:ntext',
            // 'language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
