<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

	<div class="row">

        <div class="col-md-6 col-sm-12 col-xs-12">

	        <?= GridView::widget([
		        'dataProvider' => $itemsSearch->last(5),
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
					        $cat = isset($model->category->name) ? $model->category->name : '';

					        if($cat !== '') {
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
		        'responsive' => true,
		        'hover' => true,
		        'panel' => [
			        'footer' => false,
			        'heading' => '<h3 class="panel-title"><i class="fa fa-file-text-o"></i></h3>',
			        'type' => 'info',
		        ],
	        ]) ?>

        </div>

        <div class="col-md-6 col-sm-12 col-xs-12">

	        <?= GridView::widget([
		        'dataProvider' => $categoriesSearch->last(5),
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
		        'responsive' => true,
		        'hover' => true,
		        'panel' => [
		            'footer' => false,
			        'heading' => '<h3 class="panel-title"><i class="fa fa-folder-open"></i></h3>',
			        'type' => 'danger',
		        ],
	        ]) ?>

        </div>

	</div>

	<div class="row">

        <div class="col-md-6 col-sm-12 col-xs-12">

			<?= GridView::widget([
				'dataProvider' => $tagsSearch->last(5),
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
				'responsive' => true,
				'hover' => true,
				'panel' => [
					'footer' => false,
					'heading' => '<h3 class="panel-title"><i class="fa fa-paperclip"></i></h3>',
					'type' => 'success'
				],
			]) ?>

        </div>


        <div class="col-md-6 col-sm-12 col-xs-12">

			<?= GridView::widget([
				'dataProvider' => $attachSearch->last(5),
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
							$item = isset($model->item->title) ? $model->item->title : '';

							if($item !== '') {
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
				'responsive' => true,
				'hover' => true,
				'panel' => [
					'footer' => false,
					'heading' => '<h3 class="panel-title"><i class="fa fa-tags"></i></h3>',
					'type' => 'warning'
				],
			]) ?>

        </div>

	</div>
