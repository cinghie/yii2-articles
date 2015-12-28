<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.4.1
*/

namespace cinghie\articles;

use Yii;

class Articles extends \yii\base\Module
{

    public $controllerNamespace = 'cinghie\articles\controllers';
	
	public $languages         = [ "en-GB" => "en-GB" ];
	
	public $editor 	          = "ckeditor";
	
	public $categoryImagePath = "@webroot/img/articles/categories/";

	public $categoryImageURL  = "@web/img/articles/categories/";
	
	public $categoryThumbPath = "@webroot/img/articles/categories/thumb/";

	public $categoryThumbURL  = "@web/img/articles/categories/thumb/";
	
	public $itemImagePath  	  = "@webroot/img/articles/items/";

	public $itemImageURL  	  = "@web/img/articles/items/";
	
	public $itemThumbPath     = "@webroot/img/articles/items/thumb/";

	public $itemThumbURL      = "@web/img/articles/items/thumb/";
	
	public $imageNameType 	  = "categoryname";
	
	public $imageType    	  = "image/jpg,image/jpeg,image/gif,image/png";

	public $showTitles        = false;
	
	public $thumbOptions =	[ 
		'small'  => ['quality' => 100, 'width' => 200, 'height' => 150],
		'medium' => ['quality' => 100, 'width' => 300, 'height' => 200],
		'large'  => ['quality' => 100, 'width' => 400, 'height' => 300],
		'extra'  => ['quality' => 100, 'width' => 600, 'height' => 400],
	];

	/**
	 * @inheritdoc
	 */
    public function init()
    {
        parent::init();
		$this->registerTranslations();
    }

	/**
	 * Translating module message
	 */
	public function registerTranslations()
    {
		if (!isset(Yii::$app->i18n->translations['articles*'])) 
		{
			Yii::$app->i18n->translations['articles*'] = [
				'class' => 'yii\i18n\PhpMessageSource',
				'basePath' => __DIR__ . '/messages',
			];
		}
    }

}
