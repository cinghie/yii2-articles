<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.2
*/

use cinghie\articles\assets\ArticlesAsset;

// Load Articles Assets
ArticlesAsset::register($this);
$asset = $this->assetBundles['cinghie\articles\assets\ArticlesAsset'];

// Set Title and Breadcrumbs
$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

// Decode Params
$params = json_decode($model->params);

// Render Theme
echo($this->render('themes/default',['model'=>$model,'params'=>$params]));

?>
