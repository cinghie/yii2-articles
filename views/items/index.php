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

use yii\helpers\Html;
use kartik\grid\GridView;
use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title
$this->title = Yii::t('articles', 'Items');

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>
<div class="items-index">

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
                    'attribute' => 'title',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'catid',
                    'hAlign' => 'center',
                    'value' => 'category.name'
                ],
                [
                    'attribute' => 'access',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'created_by',
                    'hAlign' => 'center',
                    'value' => 'createdby.username'
                ],
                [
                    'attribute' => 'created',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'modified_by',
                    'hAlign' => 'center',
                    'value' => 'modifiedby.username'
                ],
                [
                    'attribute' => 'modified',
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'language',
                    'width' => '6%',
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
                    'attribute' => 'id',
                    'width' => '6%',
                    'hAlign' => 'center',
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                ]
                // 'ordering',
                // 'userid',
                // 'introtext:ntext',
                // 'fulltext:ntext',
                // 'alias',
                // 'hits',
                // 'image:ntext',
                // 'image_caption',
                // 'image_credits',
                // 'video:ntext',
                // 'video_caption',
                // 'video_credits',
                // 'modified',
                // 'modified_by',
                // 'params:ntext',
                // 'metadesc:ntext',
                // 'metakey:ntext',
                // 'robots',
                // 'author',
                // 'copyright',
            ],
            'responsive' => true,
            'hover' => true,
			'panel' => [
                'heading'    => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i></h3>',
                'type'       => 'success',
                'before'     => Html::a(
                    '<i class="glyphicon glyphicon-plus"></i> '.Yii::t('articles', 'Create Item'), ['create'], ['class' => 'btn btn-success']
                ),
                'after'      => Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('articles', 'Reset Grid'), ['index'], ['class' => 'btn btn-info']
                ),
                'showFooter' => false
            ],
        ]); ?>
    </div>

</div>
