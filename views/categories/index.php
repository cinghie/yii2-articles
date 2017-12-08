<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Categories
 * @var $searchModel cinghie\articles\models\CategoriesSearch
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles[ArticlesAsset::class];

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
        .$searchModel->getUpdateButtonJavascript('#w1')
        .$searchModel->getDeleteButtonJavascript('#w1')
        .$searchModel->getActiveButtonJavascript('#w1')
        .$searchModel->getDeactiveButtonJavascript('#w1')
        .$searchModel->getPreviewButtonJavascript('#w1').
    '});
');

?>

<div class="row">

    <!-- action menu -->
    <div class="col-md-6">

        <?= Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php'); ?>

    </div>

    <!-- action buttons -->
    <div class="col-md-6">

        <?= $searchModel->getDeactiveButton() ?>

        <?= $searchModel->getActiveButton() ?>

        <?= $searchModel->getResetButton() ?>

        <?= $searchModel->getPreviewButton() ?>

        <?= $searchModel->getDeleteButton() ?>

        <?= $searchModel->getUpdateButton() ?>

        <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="categories-index">

	<?php if(Yii::$app->getModule('articles')->showTitles): ?>
		<div class="page-header">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	<?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- Categories Grid -->
    <div class="categories-grid">

		<?php Pjax::begin() ?>

            <?= GridView::widget([
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'containerOptions' => [
                    'class' => 'articles-categories-pjax-container'
                ],
                'pjaxSettings'=>[
                    'neverTimeout' => true,
                ],
                'columns' => [
                    [
                        'class' => '\kartik\grid\CheckboxColumn'
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            $url = urldecode(Url::toRoute(['/articles/categories/update', 'id' => $model->id, 'alias' => $model->alias]));
                            return Html::a($model->name,$url);
                        }
                    ],
                    [
                        'attribute' => 'parent_id',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($model) {
	                        /** @var $model cinghie\articles\models\Categories */
	                        return $model->getParentGridView('name','/articles/categories/update');
                        }
                    ],
                    [
                        'attribute' => 'access',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            /** @var $model cinghie\articles\models\Categories */
                            return $model->getAccessGridView();
                        }
                    ],
                    [
                        'attribute' => 'theme',
                        'hAlign' => 'center',
                    ],
                    [
                        'attribute' => 'image',
                        'format' => 'html',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            /** @var $model cinghie\articles\models\Categories */
	                        return $model->getImageGridView();
                        },
                        'width' => '8%',
                    ],
                    [
                        'attribute' => 'language',
                        'hAlign' => 'center',
                        'width' => '6%',
                    ],
                    [
                        'attribute' => 'state',
                        'format' => 'raw',
                        'hAlign' => 'center',
                        'width' => '6%',
                        'value' => function ($model) {
                            /** @var $model cinghie\articles\models\Categories */
                            return $model->getStateGridView();
                        }
                    ],
                    [
                        'attribute' => 'id',
                        'hAlign' => 'center',
                        'width' => '5%',
                    ]
                ],
                'responsive' => true,
                'hover' => true,
                'panel' => [
                    'heading' => '<h3 class="panel-title"><i class="fa fa-folder-open"></i></h3>',
                    'type' => 'success',
                    'footer' => ''
                ],
            ]); ?>

		<?php Pjax::end() ?>

	</div>

</div>
