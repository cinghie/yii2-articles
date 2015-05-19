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
use yii\widgets\DetailView;

// Set Title
$this->title = Html::encode($model->title);

/* MetaData */

// Add Meta Description
Yii::$app->view->registerMetaTag([
	'name'    => 'description', 
	'content' => Html::encode($model->metadesc)
]);
// Add Meta Keywords
Yii::$app->view->registerMetaTag([
	'name'    => 'keywords', 
	'content' => Html::encode($model->metakey)
]);
// Add Meta Author
if ($model->author) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'author', 
		'content' => Html::encode($model->author)
	]);
}
// Add Meta Copyright
if ($model->copyright) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'copyright', 
		'content' => Html::encode($model->copyright)
	]);
}
// Add Meta Robots 
Yii::$app->view->registerMetaTag([
	'name'    => 'robots', 
	'content' => Html::encode($model->robots)
]);

/* Facebook Open Graph */

// Add Facebook Title
Yii::$app->view->registerMetaTag([
	'property' => 'og:title', 
	'content'  => $this->title
]);
// Add Facebook Image
if ($model->image) {
	Yii::$app->view->registerMetaTag([
		'property' => 'og:image', 
		'content'  => Html::encode($model->image)
	]);
}
// Add Facebook Author
if ($model->author) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'article:author', 
		'content' => Html::encode($model->author)
	]);
}
// Add Facebook Author
if ($model->copyright) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'article:publisher', 
		'content' => Html::encode($model->copyright)
	]);
}
// Add Facebook Site Name
Yii::$app->view->registerMetaTag([
	'property' => 'og:site_name', 
	'content'  => Yii::$app->name
]);
// Add Facebook URL
Yii::$app->view->registerMetaTag([
	'property' => 'og:url', 
	'content'  => Yii::$app->request->url
]);
// Add Facebook Description
Yii::$app->view->registerMetaTag([
	'name'    => 'og:description', 
	'content' => Html::encode($model->metadesc)
]);
// Add Facebook Locale
Yii::$app->view->registerMetaTag([
	'property' => 'og:locale', 
	'content'  => str_replace("-","_",$model->language)
]);
// Add Facebook Type
Yii::$app->view->registerMetaTag([
	'property' => 'og:type', 
	'content'  => 'article'
]);

/* Twitter Card */

// Add Twitter Summary
Yii::$app->view->registerMetaTag([
	'property' => 'twitter:card', 
	'content'  => 'summary'
]);
// Add Twitter Title
Yii::$app->view->registerMetaTag([
	'property' => 'twitter:title', 
	'content'  => $this->title
]);
// Add Twitter Site Name
Yii::$app->view->registerMetaTag([
	'property' => 'twitter:site', 
	'content'  => Yii::$app->name
]);
// Add Twitter Description
Yii::$app->view->registerMetaTag([
	'name'    => 'twitter:description', 
	'content' => Html::encode($model->metadesc)
]);
// Add Twitter Author
if ($model->author) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'twitter:creator', 
		'content' => Html::encode($model->author)
	]);
}
// Add Twitter Image
if ($model->image) {
	Yii::$app->view->registerMetaTag([
		'property' => 'twitter:image:src', 
		'content'  => Html::encode($model->image)
	]);
}

?>

<article>
	<div class="item-editor">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
	<header>
    	<h1><?= Html::encode($this->title) ?></h1>
        <time pubdate datetime="<?= $model->created ?>"></time>
    </header>
    <?php if ($model->introtext): ?>
        <div class="intro-text">
            <?= $model->introtext ?>
        </div>
    <?php endif; ?>
    <?php if ($model->fulltext): ?>
        <div class="full-text">
        	<?= $model->fulltext ?>    
        </div>
    <?php endif; ?>
</article>

<div class="items-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'alias',
            'catid',
            'userid',
            'published',
            'access',
            'language',
            'ordering',
            'hits',
            'image:ntext',
            'image_caption',
            'image_credits',
            'video:ntext',
            'video_caption',
            'video_credits',
            'created',
            'created_by',
            'modified',
            'modified_by',
            'params:ntext',
        ],
    ]) ?>

</div>
