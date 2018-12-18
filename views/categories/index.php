<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Categories
 * @var $searchModel cinghie\articles\models\CategoriesSearch
 * @var $this yii\web\View
 */

use cinghie\articles\assets\ArticlesAsset;
use kartik\grid\CheckboxColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;

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

        <?= Yii::$app->view->renderFile(\Yii::$app->controller->module->tabMenu) ?>

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

    <?php // echo $this->render('_search', ['model' => $searchModel]) ?>

    <!-- Categories Grid -->
    <div class="categories-grid">

	    <?= GridView::widget([
		    'dataProvider'=> $dataProvider,
		    'filterModel' => $searchModel,
		    'containerOptions' => [
			    'class' => 'articles-categories-pjax-container'
		    ],
		    'pjax' => true,
		    'pjaxSettings'=>[
			    'neverTimeout' => true,
		    ],
		    'columns' => [
			    [
				    'class' => CheckboxColumn::class
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
				    'filterType' => GridView::FILTER_SELECT2,
				    'filter' => $searchModel->getCategoriesSelect2(),
				    'filterWidgetOptions' => [
					    'pluginOptions' => ['allowClear' => true],
				    ],
				    'filterInputOptions' => ['placeholder' => ''],
				    'format' => 'html',
				    'hAlign' => 'center',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Categories */
					    return $model->getParentGridView('name','/articles/categories/update');
				    }
			    ],
			    [
				    'attribute' => 'access',
				    'filterType' => GridView::FILTER_SELECT2,
				    'filter' => $searchModel->getRolesSelect2(),
				    'filterWidgetOptions' => [
					    'pluginOptions' => ['allowClear' => true],
				    ],
				    'filterInputOptions' => ['placeholder' => ''],
				    'format' => 'html',
				    'hAlign' => 'center',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Categories */
					    return $model->getAccessGridView();
				    }
			    ],
			    [
				    'attribute' => 'theme',
				    'filterType' => GridView::FILTER_SELECT2,
				    'filter' => $searchModel->getThemesSelect2(),
				    'filterWidgetOptions' => [
					    'pluginOptions' => ['allowClear' => true],
				    ],
				    'filterInputOptions' => ['placeholder' => ''],
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
				    'filterType' => GridView::FILTER_SELECT2,
				    'filter' => $searchModel::getLanguagesSelect2(),
				    'filterWidgetOptions' => [
					    'pluginOptions' => ['allowClear' => true],
				    ],
				    'filterInputOptions' => ['placeholder' => ''],
				    'hAlign' => 'center',
				    'width' => '6%',
			    ],
			    [
				    'attribute' => 'ordering',
				    'hAlign' => 'center',
				    'width' => '5%',
			    ],
			    [
				    'attribute' => 'state',
				    'filterType' => GridView::FILTER_SELECT2,
				    'filter' => $searchModel::getStateSelect2(),
				    'filterWidgetOptions' => [
					    'pluginOptions' => ['allowClear' => true],
				    ],
				    'filterInputOptions' => ['placeholder' => ''],
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
		    'responsiveWrap' => true,
		    'hover' => true,
		    'panel' => [
			    'heading' => '<h3 class="panel-title"><i class="fa fa-folder-open"></i></h3>',
			    'type' => 'success',
			    'footer' => ''
		    ],
	    ]) ?>

	</div>

</div>
