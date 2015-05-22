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
use yii\grid\GridView;

// Set Title
$this->title = Yii::t('articles.message', 'Items');

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>
<div class="items-index">

    <div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('articles.message', 'Create Item', [
  'modelClass' => 'Items',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            'title',
            'catid',
			'published',
            'access',
			'created_by',
			'created',
            'language',
            'ordering',
			'id',
            //'userid',
            // 'introtext:ntext',
            // 'fulltext:ntext',
            //'alias',            
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
