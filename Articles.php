<?php

/**
 * @copyright Copyright &copy;2014 Giandomenico Olini
 * @company Gogodigital - Wide ICT Solutions 
 * @website http://www.gogodigital.it
 * @package yii2-articles
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 */

namespace cinghie\articles;

use Yii;

class Articles extends \yii\base\Module
{
    public $controllerNamespace = 'cinghie\articles\controllers';
	
	public $languages  = [];
	
	public $editor 	   = "ckeditor";
	
	public $categoryimagetype = "jpg,jpeg,gif,png";
	
	public $categoryimgname = "categoryname";
	
	public $categoryimagepath = "";
	
	public $categorythumbpath = "";

    public function init()
    {
        parent::init();
		
		// Translating module messages
		\Yii::$app->getI18n()->translations['articles.*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => __DIR__.'/messages',
		];
		
    }

}
