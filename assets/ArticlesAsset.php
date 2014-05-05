<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
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
