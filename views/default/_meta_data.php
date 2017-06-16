<?php

use kartik\helpers\Html;
use yii\helpers\Url;

// Set Link Canonical
$this->registerLinkTag([
	'rel' => 'canonical',
	'href' =>Url::to([
		'articles/items/view',
		'id' => $model->id,
		'alias' => $model->alias,
		'cat' => isset($data->category->alias) ? $data->category->alias : null
	])
]);

// Add Meta Description
if ($model->metadesc) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'description', 
		'content' => Html::encode($model->metadesc)
	]);
}
// Add Meta Keywords
if ($model->metakey) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'keywords', 
		'content' => Html::encode($model->metakey)
	]);
}
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

?>