<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 1.0
*/

use yii\helpers\Html;
use kartik\grid\GridView;
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title
$this->title = Yii::t('articles.message', 'Categories');

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>

<div class="page-header">
	
    <div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <!-- Categories Grid -->
    <div class="categories-grid"> 
        <?= GridView::widget([
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
				[
					'class' => '\kartik\grid\CheckboxColumn'
				],
				[
					'attribute' => 'id',
					'width' => '8%',
					'hAlign' => 'center',
				],
				'name',
				[ 
					'attribute' => 'parentid',
					'value'     => function($model, $key, $index, $column) {
						return $model->getParentName();
					}
				],
				'access',
				/*'ordering',*/
				[
					'attribute' => 'language',
					'width' => '7%',
					'hAlign' => 'center',
				],
				[ 
					'class' => '\kartik\grid\BooleanColumn',
					'attribute' => 'published',
					'trueLabel' => '1',
					'falseLabel' => '0',
					'hAlign' => 'center'
				],
				[
					'class' => '\kartik\grid\ActionColumn',
				]
			],
            'responsive' => true,
            'hover' => true,
			'panel' => [
				'heading'    => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i></h3>',
				'type'       => 'success',
				'before'     => Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('articles.message', 'Create Category'), ['create'], ['class' => 'btn btn-success']
				),				
				'after'      => Html::a(
					'<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('articles.message', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
				),
				'showFooter' => false
			],
        ]); ?>
	</div>

</div>
