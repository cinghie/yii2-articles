<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-articles
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-articles
 * @version 0.6.6
 */

namespace cinghie\articles\filters;

use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\web\NotFoundHttpException;

/**
 * FrontendFilter class
 */
class FrontendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = ['index','create','update','translate','changestate','activemultiple','deactivemultiple','delete','deletemultiple','deleteonfly','deleteimage'];

    /**
     * @param Action $action
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->action->id, $this->controllers, true)) {
            throw new NotFoundHttpException(Yii::t('traits','Page not found'));
        }

        return true;
    }
}
