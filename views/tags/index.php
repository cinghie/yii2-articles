<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Tags
 * @var $searchModel cinghie\articles\models\TagsSearch
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

$this->title = Yii::t('articles', 'Tags');
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

<div class="tags-index">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]) ?>

    <div class="tags-grid">

	    <?= GridView::widget([
		    'dataProvider'=> $dataProvider,
		    'filterModel' => $searchModel,
		    'containerOptions' => [
			    'class' => 'tags-pjax-container'
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
					    $url = urldecode(Url::toRoute(['/articles/tags/update', 'id' => $model->id, 'alias' => $model->alias]));
					    return Html::a($model->name,$url);
				    }
			    ],
			    [
				    'attribute' => 'alias',
				    'width' => '35%',
				    'hAlign' => 'center',
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
					    if($model->state) {
						    return Html::a('<span class="glyphicon glyphicon-ok text-success"></span>', ['changestate', 'id' => $model->id], [
							    'data-method' => 'post',
						    ]);
					    }

					    return Html::a('<span class="glyphicon glyphicon-remove text-danger"></span>', ['changestate', 'id' => $model->id], [
						    'data-method' => 'post',
					    ]);
				    },
			    ],
			    [
				    'attribute' => 'id',
				    'width' => '5%',
				    'hAlign' => 'center',
			    ]
		    ],
		    'responsive' => true,
		    'responsiveWrap' => true,
		    'hover' => true,
		    'panel' => [
			    'heading'    => '<h3 class="panel-title"><i class="fa fa-tags"></i></h3>',
			    'type'       => 'success',
		    ],
	    ]) ?>

    </div>

</div>
