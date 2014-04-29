<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\articles\models\CategoriesSearch $searchModel
 */

$this->title = Yii::t('articles.message', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-index">
	<div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Categories',
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
            // 'image_caption:ntext',
            // 'image_credits',
            // 'params:ntext',
            // 'metadesc:ntext',
            // 'metakey:ntext',
            // 'robots',
            // 'author',
            // 'copyright',
            // 'language',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
