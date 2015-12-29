<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.4.1
*/

use cinghie\articles\assets\ArticlesAsset;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title and Breadcrumbs
$this->title = Yii::t('articles', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

// Register action buttons js
$this->registerJs('
    $(document).ready(function()
    {
        $("a.btn-update").click(function() {
            var selectedId = $("#w1").yiiGridView("getSelectedRows");

            if(selectedId.length == 0) {
                alert("'.Yii::t("articles", "Select at least one item").'");
            } else if(selectedId.length>1){
                alert("'.Yii::t("articles", "Select only 1 item").'");
            } else {
                var url = "'.Url::to(['/articles/items/update']).'&id="+selectedId[0];
                window.location.href= url;
            }
        });
    });
');

?>

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
            'columns' => [
				[
					'class' => '\kartik\grid\CheckboxColumn'
				],
				[
					'attribute' => 'name',
					'hAlign' => 'center',
				],
				[
					'attribute' => 'parentid',
					'hAlign' => 'center',
					'value' => 'parent.name'
				],
				[
					'attribute' => 'access',
					'hAlign' => 'center',
				],
				[
					'attribute' => 'image',
					'format' => 'html',
					'hAlign' => 'center',
					'value' => function ($model, $key, $index, $column) {
						if ($model->image) {
							return Html::img($model->getImageThumbUrl("small"),
								['width' => '36px']);
						}
					},
					'width' => '8%',
				],
				[
					'attribute' => 'language',
					'hAlign' => 'center',
					'width' => '7%',
				],
				[ 
					'class' => '\kartik\grid\BooleanColumn',
					'attribute' => 'published',
					'hAlign' => 'center',
					'trueLabel' => '1',
					'falseLabel' => '0'
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
				'heading'    => '<h3 class="panel-title"><i class="fa fa-folder-open"></i></h3>',
				'type'       => 'success',
				'before'     => Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('articles', 'New'), ['create'], ['class' => 'btn btn-success']
				),				
				'after'      => Html::a(
					'<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('articles', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
				),
				'showFooter' => false
			],
        ]); ?>

		<?php Pjax::end() ?>

	</div>

</div>
