<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.3
*/

use yii\helpers\Html;
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