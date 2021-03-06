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

namespace cinghie\articles\controllers;

use RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
	/**
	 * @inheritdoc
	 */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin']
                    ],
                ],
                'denyCallback' => function () {
                    throw new RuntimeException(Yii::t('traits','You are not allowed to access this page'));
                }
            ],
        ];
    }

	/**
	 * Lists all Categories models
	 *
	 * @return mixed
	 * @throws InvalidParamException
	 */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
