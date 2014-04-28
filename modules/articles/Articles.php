<?php

namespace app\modules\articles;

use Yii;

class Articles extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\articles\controllers';
	
	public $languages = [];

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
