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

// Add Facebook Title
Yii::$app->view->registerMetaTag([
	'property' => 'og:title', 
	'content'  => Html::encode($this->title)
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
if ($model->metadesc) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'og:description', 
		'content' => Html::encode($model->metadesc)
	]);
}
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

?>