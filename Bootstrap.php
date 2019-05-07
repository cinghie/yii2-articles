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

namespace cinghie\articles;

use Yii;
use cinghie\articles\models\Items;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\db\ActiveRecord;

/**
 * Bootstrap class
 */
class Bootstrap implements BootstrapInterface
{
    /** @var array Model's map */
    private $_modelMap = [
        'Items' => Items::class,
    ];

    /** @inheritdoc */
    public function bootstrap($app)
    {
        /**
         * @var Module $module
         * @var ActiveRecord $modelName
         */
        if ($app->hasModule('articles') && ($module = $app->getModule('articles')) instanceof Module)
        {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);

            foreach ($this->_modelMap as $name => $definition)
            {
                $class = "cinghie\\articles\\models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
                if (in_array($name, ['User', 'Profile', 'Token', 'Account'])) {
                    Yii::$container->set($name . 'Query', function () use ($modelName) {
                        return $modelName::find();
                    });
                }
            }
        }
    }
}
