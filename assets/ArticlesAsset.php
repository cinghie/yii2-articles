<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-articles
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 */

namespace cinghie\articles\assets;

use yii\web\AssetBundle;

class ArticlesAsset extends AssetBundle
{
	public $sourcePath = __DIR__;
	public $css = array(
		'css/articles.css',
	);

}
