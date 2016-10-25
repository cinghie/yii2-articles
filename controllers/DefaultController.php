<?php

/**
* @copyright Copyright &copy; Gogodigital Srls
* @company Gogodigital Srls - Wide ICT Solutions 
* @website http://www.gogodigital.it
* @github https://github.com/cinghie/yii2-articles
* @license GNU GENERAL PUBLIC LICENSE VERSION 3
* @package yii2-articles
* @version 0.6.3
*/

namespace cinghie\articles\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index'], 'roles' => ['@']],
                ],
                'denyCallback' => function () {
                    throw new \Exception('You are not allowed to access this page');
                }
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
