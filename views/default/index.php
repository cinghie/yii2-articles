<?php

use cinghie\adminlte\widgets\Box;
use cinghie\adminlte\widgets\Simplebox3;
use cinghie\articles\models\Attachments;
use cinghie\articles\models\AttachmentsSearch;
use cinghie\articles\models\Items;
use cinghie\articles\models\ItemsSearch;
use cinghie\articles\models\Tags;
use cinghie\articles\models\TagsSearch;
use cinghie\userextended\models\User;
use cinghie\userextended\models\UserSearch;
use dektrium\user\Finder;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = Yii::t('articles', 'Dashboard');
$this->params['breadcrumbs'][] = $this->title;

$attachSearch = new AttachmentsSearch();
$itemsSearch  = new ItemsSearch();
$tagsSearch   = new TagsSearch();
$usersSearch  = new UserSearch(new Finder());

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
			'icon' => 'fa fa-tags',
			'link' => Url::to(['/articles/tags/index']),
			'title' => Tags::find()->count(),
			'subtitle' => Yii::t('articles','Tags')
		]) ?>

		<?= Simplebox3::widget([
			'bgclass' => 'bg-yellow',
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-paperclip',
			'link' => Url::to(['/articles/attachments/index']),
			'title' => Attachments::find()->count(),
			'subtitle' => Yii::t('articles','Attachments')
		]) ?>

		<?= Simplebox3::widget([
			'bgclass' => 'bg-red',
			'class' => 'col-md-3 col-sm-6 col-xs-12',
			'description' => Yii::t('traits', 'More info'),
			'icon' => 'fa fa-users',
			'link' => Url::to(['/user/admin/index']),
			'title' => User::find()->count(),
			'subtitle' => Yii::t('user','Users')
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
			'buttonLeftTitle' => Yii::t('userextended','New User'),
			'buttonRightTitle' => Yii::t('userextended','All Users'),
			'buttonLeftLink' => Url::to(['/user/admin/create']),
			'buttonRightLink' => Url::to(['/user/admin/index']),
			'columns' => [
				[
					'attribute' => 'username',
					'format' => 'html',
					'hAlign' => 'center',
					'value' => function ($model) {
						$url = urldecode(Url::toRoute(['/user/admin/update', 'id' => $model->id]));
						return Html::a($model->username,$url);
					}
				],
				[
					'attribute' => 'email',
					'format' => 'email',
					'hAlign' => 'center',
				],
				[
					'attribute' => 'created_at',
					'filter' => DatePicker::widget([
						'attribute'  => 'created_at',
						'dateFormat' => 'php:Y-m-d',
						'options' => [
							'class' => 'form-control',
						],
					]),
					'hAlign' => 'center',
					'value' => function ($model) {
						return date('Y-m-d H:i:s', $model->created_at);
					},
				],
				[
					'attribute' => 'id',
					'hAlign' => 'center',
					'width' => '7%',
				]
			],
			'dataProvider' => $usersSearch->last(5),
			'type' => 'box-danger',
			'title' => Yii::t('userextended','Last Users'),
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
			'type' => 'box-success',
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
			'type' => 'box-warning',
			'title' => Yii::t('articles','Last Attachments'),
		]) ?>

    </div>

</div>
