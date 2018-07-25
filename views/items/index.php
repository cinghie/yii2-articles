<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Items
 * @var $searchModel cinghie\articles\models\ItemsSearch
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
$this->title = Yii::t('articles', 'Items');
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

<div class="items-index">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]) ?>

    <!-- Categories Grid -->
    <div class="items-grid">

	    <?= GridView::widget([
		    'dataProvider'=> $dataProvider,
		    'filterModel' => $searchModel,
		    'containerOptions' => [
			    'class' => 'articles-items-pjax-container'
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
				    'attribute' => 'title',
				    'format' => 'html',
				    'hAlign' => 'center',
				    'value' => function ($model) {
					    $url = urldecode(Url::toRoute(['/articles/items/update',
						    'id' => $model->id,
						    'alias' => $model->alias,
						    'cat' => isset($model->category->alias) ? $model->category->alias : null
					    ]));
					    return Html::a($model->title,$url);
				    }
			    ],
			    [
				    'attribute' => 'cat_id',
				    'format' => 'html',
				    'hAlign' => 'center',
				    'value' => function ($model) {
					    $url = urldecode(Url::toRoute(['/articles/categories/update', 'id' => $model->cat_id]));
					    $cat = isset($model->category->name) ? $model->category->name : '';

					    if($cat !== '') {
						    return Html::a($cat,$url);
					    }

					    return '<span class="fa fa-ban text-danger"></span>';
				    }
			    ],
			    [
				    'attribute' => 'access',
				    'format' => 'html',
				    'hAlign' => 'center',
				    'width' => '8%',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Items */
					    return $model->getAccessGridView();
				    }
			    ],
			    [
				    'attribute' => 'created_by',
				    'hAlign' => 'center',
				    'format' => 'raw',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Items */
					    return $model->getCreatedByGridView();
				    }
			    ],
			    [
				    'attribute' => 'created',
				    'hAlign' => 'center',
			    ],
			    [
				    'attribute' => 'modified_by',
				    'hAlign' => 'center',
				    'format' => 'raw',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Items */
					    return $model->getModifiedByGridView();
				    }
			    ],
			    [
				    'attribute' => 'modified',
				    'hAlign' => 'center',
			    ],
			    [
				    'attribute' => 'image',
				    'format' => 'html',
				    'hAlign' => 'center',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Items */
					    return $model->getImageGridView();
				    },
				    'width' => '6%',
			    ],
			    [
				    'attribute' => 'language',
				    'hAlign' => 'center',
				    'width' => '5%',
			    ],
			    [
				    'attribute' => 'ordering',
				    'hAlign' => 'center',
				    'width' => '5%',
			    ],
			    [
				    'attribute' => 'state',
				    'format' => 'raw',
				    'hAlign' => 'center',
				    'width' => '5%',
				    'value' => function ($model) {
					    /** @var $model cinghie\articles\models\Items */
					    return $model->getStateGridView();
				    }
			    ],
			    [
				    'attribute' => 'id',
				    'width' => '5%',
				    'hAlign' => 'center',
			    ]
		    ],
		    'responsive' => true,
		    'hover' => true,
		    'panel' => [
			    'heading' => '<h3 class="panel-title"><i class="fa fa-files-o"></i></h3>',
			    'type' => 'success',
		    ],
	    ]) ?>

    </div>

</div>
