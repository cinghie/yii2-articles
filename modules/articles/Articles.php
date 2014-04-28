<?php

namespace app\modules\articles;

class Articles extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\articles\controllers';
	
	public $languages = [];

    public function init()
    {
        parent::init();
		
    }
}
