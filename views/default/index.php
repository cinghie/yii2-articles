<?php

use cinghie\adminlte\widgets\Box;
use cinghie\adminlte\widgets\Simplebox3;
use cinghie\articles\models\Attachments;
use cinghie\articles\models\AttachmentsSearch;
use cinghie\articles\models\Categories;
use cinghie\articles\models\CategoriesSearch;
use cinghie\articles\models\Items;
use cinghie\articles\models\ItemsSearch;
use cinghie\articles\models\Tags;
use cinghie\articles\models\TagsSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = Yii::t('articles', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

$attachSearch = new AttachmentsSearch();
$categoriesSearch = new CategoriesSearch();
$itemsSearch = new ItemsSearch();
$tagsSearch = new TagsSearch();

?>

<?= $this->render('_menu') ?>

<div class="site-index">

    <div class="row">

		<?= Simplebox3::widget([
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-files-o',
			'link' => Url::to(['/articles/items/index']),
			'title' => Items::find()->count(),
			'subtitle' => Yii::t('articles','Items')
		]) ?>

		<?= Simplebox3::widget([
			'bgclass' => 'bg-green',
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-folder-open',
			'link' => Url::to(['/articles/categories/index']),
			'title' => Categories::find()->count(),
			'subtitle' => Yii::t('articles','Categories')
		]) ?>

		<?= Simplebox3::widget([
			'bgclass' => 'bg-yellow',
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-tags',
			'link' => Url::to(['/articles/tags/index']),
			'title' => Tags::find()->count(),
			'subtitle' => Yii::t('articles','Tags')
		]) ?>

		<?= Simplebox3::widget([
			'bgclass' => 'bg-red',
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-paperclip',
			'link' => Url::to(['/articles/attachments/index']),
			'title' => Attachments::find()->count(),
			'subtitle' => Yii::t('articles','Attachments')
		]) ?>

    </div>

    <div class="row">

		<?= Box::widget([
			'class' => 'col-md-6 col-sm-12 col-xs-12',
			'buttonLeftTitle' => Yii::t('articles','New Item'),
			'buttonRightTitle' => Yii::t('articles','All Items'),
			'buttonLeftLink' => Url::to(['/articles/items/create']),
			'buttonRightLink' => Url::to(['/articles/items/index']),
			'columns' => [
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
						$cat = isset($model->category->name) ? $model->category->name : "";

						if($cat !== "") {
							return Html::a($cat,$url);
						} else {
							return '<span class="fa fa-ban text-danger"></span>';
						}
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
					'width' => '20%',
				],
				[
					'attribute' => 'id',
					'hAlign' => 'center',
					'width' => '7%',
				]
			],
			'dataProvider' => $itemsSearch->last(5),
			'type' => 'box-primary',
			'title' => Yii::t('articles','Last Items'),
		]) ?>

		<?= Box::widget([
			'class' => 'col-md-6 col-sm-12 col-xs-12',
			'buttonLeftTitle' => Yii::t('articles','New Category'),
			'buttonRightTitle' => Yii::t('articles','All Categories'),
			'buttonLeftLink' => Url::to(['/articles/categories/create']),
			'buttonRightLink' => Url::to(['/articles/categories/index']),
			'columns' => [
				[
					'attribute' => 'name',
					'format' => 'html',
					'hAlign' => 'center',
					'value' => function ($model) {
						$url = urldecode(Url::toRoute(['categories/update', 'id' => $model->id, 'alias' => $model->alias]));
						return Html::a($model->name,$url);
					}
				],
				[
					'attribute' => 'parent_id',
					'format' => 'html',
					'hAlign' => 'center',
					'value' => function ($model) {
						/** @var $model cinghie\articles\models\Categories */
						return $model->getParentGridView('name','categories/update');
					}
				],
				[
					'attribute' => 'image',
					'format' => 'html',
					'hAlign' => 'center',
					'value' => function ($model) {
						/** @var $model cinghie\articles\models\Categories */
						return $model->getImageGridView();
					},
					'width' => '10%',
				],
				[
					'attribute' => 'id',
					'hAlign' => 'center',
					'width' => '7%',
				]
			],
			'dataProvider' => $categoriesSearch->last(5),
			'type' => 'box-success',
			'title' => Yii::t('articles','Last Categories'),
		]) ?>

    </div>

    <div class="row">

		<?= Box::widget([
			'class' => 'col-md-6 col-sm-12 col-xs-12',
			'buttonLeftTitle' => Yii::t('articles','New Tag'),
			'buttonRightTitle' => Yii::t('articles','All Tags'),
			'buttonLeftLink' => Url::to(['/articles/tags/create']),
			'buttonRightLink' => Url::to(['/articles/tags/index']),
			'columns' => [
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
					'attribute' => 'id',
					'hAlign' => 'center',
					'width' => '7%',
				]
			],
			'dataProvider' => $tagsSearch->last(5),
			'type' => 'box-warning',
			'title' => Yii::t('articles','Last Tags'),
		]) ?>

		<?= Box::widget([
			'class' => 'col-md-6 col-sm-12 col-xs-12',
			'buttonLeftTitle' => Yii::t('articles','New Attachment'),
			'buttonRightTitle' => Yii::t('articles','All Attachments'),
			'buttonLeftLink' => Url::to(['/articles/attachments/create']),
			'buttonRightLink' => Url::to(['/articles/attachments/index']),
			'columns' => [
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
					'value' => function ($model) {
						$url  = urldecode(Url::toRoute(['/articles/items/update', 'id' => $model->item_id]));
						$item = isset($model->item->title) ? $model->item->title : "";

						if($item !== "") {
							return Html::a($item,$url);
						} else {
							return Yii::t('articles', 'Nobody');
						}
					}
				],
				[
					'attribute' => 'filename',
					'format' => 'html',
					'hAlign' => 'center'
				],
				[
					'attribute' => 'id',
					'hAlign' => 'center',
					'width' => '7%',
				]
			],
			'dataProvider' => $attachSearch->last(5),
			'type' => 'box-danger',
			'title' => Yii::t('articles','Last Attachments'),
		]) ?>

    </div>

</div>
