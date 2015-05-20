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
if ($model->metadesc) {
	Yii::$app->view->registerMetaTag([
		'name'    => 'twitter:description', 
		'content' => Html::encode($model->metadesc)
	]);
}
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