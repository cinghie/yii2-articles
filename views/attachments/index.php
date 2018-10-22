<?php

/**
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model cinghie\articles\models\Attachments
 * @var $searchModel cinghie\articles\models\AttachmentsSearch
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
$this->title = Yii::t('articles', 'Attachments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('articles', 'Articles'), 'url' => ['/articles/default/index']];
$this->params['breadcrumbs'][] = $this->title;

// Register action buttons js
$this->registerJs('$(document).ready(function() 
    {'
    .$searchModel->getUpdateButtonJavascript('#w1')
    .$searchModel->getDeleteButtonJavascript('#w1')
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

        <?= $searchModel->getResetButton() ?>

        <?= $searchModel->getPreviewButton() ?>

        <?= $searchModel->getDeleteButton() ?>

        <?= $searchModel->getUpdateButton() ?>

        <?= $searchModel->getCreateButton() ?>

    </div>

</div>

<div class="separator"></div>

<div class="attachments-index">

    <?php if(Yii::$app->getModule('articles')->showTitles): ?>
        <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    <?php endif ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]) ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'containerOptions' => [
			'class' => 'articles-attachments-pjax-container'
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
					$url = urldecode(Url::toRoute(['/articles/attachments/update', 'id' => $model->id]));
					return Html::a($model->title,$url);
				}
			],
			[
				'attribute' => 'item_id',
				'format' => 'html',
				'hAlign' => 'center',
				'width' => '12%',
				'value' => function ($model) {
					$url  = urldecode(Url::toRoute(['/articles/items/update', 'id' => $model->item_id]));
					$item = isset($model->item->title) ? $model->item->title : '';

					if($item !== '') {
						return Html::a($item,$url);
					}

					return Yii::t('articles', 'Nobody');
				}
			],
			[
				'attribute' => 'filename',
				'format' => 'html',
				'hAlign' => 'center',
				'width' => '12%',
				'value' => function ($model) {
					/** @var $model cinghie\articles\models\Attachments */
					return Html::a($model->filename,$model->getFileUrl());
				}
			],
			[
				'attribute' => 'extension',
				'format' => 'html',
				'hAlign' => 'center',
				'width' => '8%',
				'value' => function ($model) {
					/** @var $model cinghie\articles\models\Attachments */
					return $model->getAttachmentTypeIcon(). ' (' .$model->extension. ')';
				}
			],
			[
				'attribute' => 'size',
				'hAlign' => 'center',
				'width' => '8%',
				'value' => function ($model) {
					/** @var $model cinghie\articles\models\Attachments */
					return $model->formatSize();
				}
			],
			[
				'attribute' => 'hits',
				'hAlign' => 'center',
				'width' => '6%',
			],
			[
				'attribute' => 'id',
				'hAlign' => 'center',
				'width' => '6%',
			],
		],
		'responsive' => true,
		'responsiveWrap' => true,
		'hover' => true,
		'panel' => [
			'heading'    => '<h3 class="panel-title"><i class="fa fa-paperclip"></i></h3>',
			'type'       => 'success',
			'showFooter' => false
		],
	]) ?>

</div>
