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

namespace cinghie\articles;

class Articles extends \yii\base\Module
{
    public $controllerNamespace = 'cinghie\articles\controllers';
	
	public $languages           = [ "en-GB" => "en-GB" ];
	
	public $editor 	            = "ckeditor";
	
	public $categoryImagePath   = "img/articles/categories/";
	
	public $categoryThumbPath   = "img/articles/categories/thumb/";
	
	public $itemImagePath  		= "img/articles/items/";
	
	public $itemThumbPath   	= "img/articles/items/thumb/";
	
	public $imageNameType 		= "categoryname";
	
	public $imageType    		= "image/jpg,image/jpeg,image/gif,image/png";
	
	public $thumbOptions =	[ 
		'small'  => ['quality' => 100, 'width' => 200, 'height' => 150],
		'medium' => ['quality' => 100, 'width' => 300, 'height' => 200],
		'large'  => ['quality' => 100, 'width' => 400, 'height' => 300],
		'extra'  => ['quality' => 100, 'width' => 600, 'height' => 400],
	];

    public function init()
    {
        parent::init();
		$this->registerTranslations();
    }
	
	public function registerTranslations()
    {
        // Translating module messages
		\Yii::$app->getI18n()->translations['articles.*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => __DIR__.'/messages',
		];
    }
}
