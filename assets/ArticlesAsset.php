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
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'kartik\form\ActiveFormAsset',
		'kartik\base\WidgetAsset',
		'kartik\select2\Select2Asset',
		'kartik\select2\ThemeKrajeeAsset',
		'kartik\datetime\DateTimePickerAsset',
		'kartik\file\FileInputAsset',
    ];

}
