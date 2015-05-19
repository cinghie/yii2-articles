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

use yii\helpers\Html;

// Set Title
$this->title = Yii::t('app', 'Create Categories');

// Render Yii2-Articles Menu
echo Yii::$app->view->renderFile('@vendor/cinghie/yii2-articles/views/default/_menu.php');

?>

<div class="categories-create">

	<div class="page-header">
    	<h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [ 'model' => $model, ]) ?>

</div>
