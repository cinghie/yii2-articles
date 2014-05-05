<?php

namespace cinghie\articles;

use Yii;

class Articles extends \yii\base\Module
{
    public $controllerNamespace = 'cinghie\articles\controllers';
	
	public $languages  = [];
	
	public $editor 	   = "";
	
	public $categoryimagepath = "";
	
	public $categorythumbpath = "";
	
	public $categoryimagetype = "";

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
