<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\articles\models\search\ArticlesCategoriesSearch $searchModel
 */

$this->title = Yii::t('app', 'Articles Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Articles Categories',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'alias',
            'description:ntext',
            'parent',
            // 'published',
            // 'access',
            // 'ordering',
            // 'image',
            // 'params:ntext',
            // 'metadesc:ntext',
            // 'metakey:ntext',
            // 'language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
