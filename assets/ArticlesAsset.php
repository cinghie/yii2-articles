<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.5
 */

namespace cinghie\articles\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use kartik\form\ActiveFormAsset;
use kartik\base\WidgetAsset;
use kartik\select2\Select2Asset;
use kartik\select2\ThemeKrajeeAsset;
use kartik\datetime\DateTimePickerAsset;
use kartik\file\FileInputAsset;

class ArticlesAsset extends AssetBundle
{
	/**
	 * @inherit
	 */
	public $sourcePath = '@vendor/cinghie/yii2-articles/assets/assets';

	/**
	 * @inherit
	 */
	public $css = array(
		'//fonts.googleapis.com/css?family=Roboto:400,700',
		'//fonts.googleapis.com/css?family=Open+Sans:400,700',
		'css/articles.css',
	);

	/**
	 * @inherit
	 */
	public $depends = [
		YiiAsset::class,
		BootstrapAsset::class,
		BootstrapPluginAsset::class,
		ActiveFormAsset::class,
		WidgetAsset::class,
		Select2Asset::class,
		ThemeKrajeeAsset::class,
		DateTimePickerAsset::class,
		FileInputAsset::class,
    ];
}
